<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $form = $this->createFormBuilder($newUser)
            ->add('surname', TextType::class)
            ->add('name', TextType::class)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('envoyer', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bcryptPass = password_hash($newUser->getPassword(), PASSWORD_BCRYPT);
            $newUser->setPassword($bcryptPass)
                    ->setLastLog(new DateTime())
                    ->setCreatedAt(new DateTime())
                    ->setRoles(['ROLE_MEMBRE']);

            $manager->persist($newUser);
            $manager->flush();
            $this->addFlash('success', "Le membre a bien été enregistré en base de donées.");

            return $this->redirectToRoute("signIn");
        }

        return $this->render('admin/signin.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
