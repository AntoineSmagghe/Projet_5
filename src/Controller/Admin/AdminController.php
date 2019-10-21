<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Users;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="login", methods={"POST", "GET"})
     */
    public function login(Request $request, UsersRepository $usersRepository)
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
                if (password_verify($users->getPassword(), $userInDb->getPassword())){
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
     * @Route("/signin", name="signIn", methods={"POST", "GET"})
     */
    public function signIn(ObjectManager $manager, Request $request)
    {
        $newUser = new Users();
        $form = $this->createFormBuilder($newUser)
            ->add('surname', TextType::class)
            ->add('name', TextType::class)
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('envoyer', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);

        dump($newUser);

        if ($form->isSubmitted() && $form->isValid()){
            
            $bcryptPass = password_hash($newUser->getPassword(), PASSWORD_BCRYPT);
            
            $newUser->setPassword($bcryptPass);
            $newUser->setCreatedAt(new DateTime());

            $manager->persist($newUser);
            $manager->flush();

            return $this->redirectToRoute("home_public");
        }

        return $this->render('admin/signin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Request $request, ObjectManager $manager)
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('date_event', DateType::class, ['widget' => 'single_text'])
            ->add('format', ChoiceType::class, [
                'choices' => [
                    'Event Public' => 'publicEvent',
                    'Event Privé' => 'privateEvent',
                    'News' => 'news',
                    'Release' => 'releases',
                    'Membres' => 'members'
            ]])
            ->add('title', TextType::class)
            ->add('text', TextareaType::class, ['required' => false])
            ->add('api_data', TextType::class, ['required' => false])
            ->add('save', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $article->setCreatedAt(new DateTime());
            $article->setIdAdmin(1);
            $article->setIdImg(9999999);

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article', [
                'format' => $article->getFormat(), 
                'id' => $article->getId()
                ]);
        }
        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView()
        ]);
    }
}