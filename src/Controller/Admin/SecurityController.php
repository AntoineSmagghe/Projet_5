<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="login", methods={"POST", "GET"})
     */
    public function login(Request $request, UsersRepository $usersRepository, ObjectManager $manager)
    {
        /*
        $users = new Users();
        $form = $this->createFormBuilder($users)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('login', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userInDb = $usersRepository->findOneByMail($users->getMail());
            if ($userInDb) {
                if (password_verify($users->getPassword(), $userInDb->getPassword())){
                    $userInDb->setLastLog(new DateTime());
                    $manager->persist($userInDb);
                    $manager->flush();
                    
                    return $this->redirectToRoute('editPost');
                } else {
                    return $this->redirectToRoute('home_public');
                    // message d'erreur de login.
                }
            } else {
                // Mettre un message d'erreur qui affiche login non valable.
            }
        }
        */
        return $this->render('security/login.html.twig', /*[
            'form' => $form->createView()
        ]*/);
    }

    /**
     * @Route("/admin/signin", name="signIn", methods={"POST", "GET"})
     */
    public function signIn(ObjectManager $manager, Request $request)
    {
        $newUser = new Users();
        $form = $this->createFormBuilder($newUser)
            ->add('surname', TextType::class)
            ->add('userName', TextType::class)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('envoyer', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bcryptPass = password_hash($newUser->getPassword(), PASSWORD_BCRYPT);
            $newUser->setPassword($bcryptPass)
                    ->setCreatedAt(new DateTime())
                    ->setRoles(['ROLE_ADMIN']);
            $manager->persist($newUser);
            $manager->flush();

            $this->addFlash('success', 'Nouvel utilisateur bien enregistré!');

            return $this->redirectToRoute("home_public");
        }

        return $this->render('admin/signin.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
