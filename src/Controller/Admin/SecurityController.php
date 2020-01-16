<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Users;
use App\Form\ResetMailType;
use App\Form\ResetPasswordType;
use App\Form\UserIdentityType;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/{_locale}/connexion", requirements={"_locale": "fr|en"}, name="login", methods={"POST", "GET"})
     */
    public function login(AuthenticationUtils $authUtils, Security $security, Request $request)
    {
        /*
        if ($request->get('security.authentication.success')){
            $usr = $security->getUser();
            dump($usr); 
        }
        */
        $error = $authUtils->getLastAuthenticationError();
        $lastName = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_user' => $lastName,
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout(){}

    /**
     * @Route("/{_locale}/admin/signin", requirements={"_locale": "fr|en"}, name="signIn", methods={"POST", "GET"})
     */
    public function signIn(EntityManagerInterface $manager, Request $request)
    {
        $newUser = new Users();
        $form = $this->createForm(UsersType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bcryptPass = password_hash($newUser->getPassword(), PASSWORD_BCRYPT);
            $newUser->setPassword($bcryptPass)
                    ->setLastLog(new DateTime())
                    ->setCreatedAt(new DateTime());

            $manager->persist($newUser);
            $manager->flush();
            $this->addFlash('success', "Le membre a bien été enregistré en base de données.");

            return $this->redirectToRoute("signIn");
        }

        return $this->render('admin/signin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{_locale}/users/account", requirements={"_locale": "fr|en"}, name="account", methods={"POST", "GET"})
     */
    public function account(EntityManagerInterface $manager, Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserIdentityType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', "Les changements ont bien été enregistrés en base de données.");
            return $this->redirectToRoute("account");
        }

        return $this->render('users/account.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{_locale}/users/reset-password", requirements={"_locale": "fr|en"}, name="resetPassword", methods={"POST", "GET"})
     */
    public function resetPassword(UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordEncoder->isPasswordValid($user, $request->request->get('reset_password')['oldPassword'])){
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getResetPassword());
                $user->setPassword($newEncodedPassword);
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('account');
            } else {
                $this->addFlash('fail', 'Ancien mot de passe incorrect');
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('users/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{_locale}/users/reset-email", requirements={"_locale": "fr|en"}, name="resetMail", methods={"POST", "GET"})
     */
    public function resetMail(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetMailType::class, $user);
        $form->handleRequest($request);
        try{
            if ($form->isSubmitted() && $form->isValid()){
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Votre adresse mail a bien été changée !');
                return $this->redirectToRoute('account');
            }
        } catch(Exception $e){
            $this->addFlash('fail', $e);
        }
        return $this->render('users/reset_mail.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
