<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Users;
use App\Form\ArticleType;
use App\Repository\UsersRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="login", methods={"POST", "GET"})
     */
    public function login(Request $request, ObjectManager $manager, UsersRepository $usersRepository)
    {
        
        $users = new Users();
        $form = $this->createFormBuilder($users)
                    ->add('mail', EmailType::class)
                    ->add('password', PasswordType::class)
                    ->add('login', SubmitType::class)
                    ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userInDb = $usersRepository->findOneByMail($users->getMail());
            if ($userInDb){
                if ($users->getPassword() == $userInDb->getPassword()){
                    return $this->redirectToRoute('editPost');
                } 
                else{
                    return $this->redirectToRoute('home_public');
                    // message d'erreur de login.
                }
            }else{
                // Mettre un message d'erreur qui affiche login non valable.
            }
        }

        return $this->render('admin/login.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Request $request, ObjectManager $manager)
    {
        if(!isset($article)){
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($form);
            $manager->flush();
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}