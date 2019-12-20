<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Users;
use App\Form\ResetPasswordType;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="login", methods={"POST", "GET"})
     */
    public function login(AuthenticationUtils $authUtils, Security $security, Request $request)
    {
        if ($request->get('security.authentication.success')){
            $usr = $security->getUser();
            dump($usr);
        }
        
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
     * @Route("/admin/signin", name="signIn", methods={"POST", "GET"})
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
     * @Route("/users/account", name="account", methods={"POST", "GET"})
     */
    public function account(EntityManagerInterface $manager, Request $request)
    {
        if ($request->getContent() == null){
            $user = $this->getUser();
        } else {
            $user = new Users();
        }
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $bcryptPass = password_hash($user->getPassword(), PASSWORD_BCRYPT);
            $user->setPassword($bcryptPass);
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
     * @Route("/users/reset-password", name="resetPassword", methods={"POST, "GET"})
     */
    public function resetPassword(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->request->get('etiquettebundle_user')['oldPassword'];

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($newEncodedPassword);

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('account');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('users/reset_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
