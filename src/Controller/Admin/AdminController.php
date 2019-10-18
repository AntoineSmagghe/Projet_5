<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Users;
use App\Form\ArticleType;
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
    public function login(){
        $users = new Users();
        $form = $this->createFormBuilder($users)
                    ->add('mail', EmailType::class)
                    ->add('password', PasswordType::class)
                    ->add('login', SubmitType::class)
                    ->getForm();

        return $this->render('admin/login.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(ObjectManager $manager, Request $request)
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