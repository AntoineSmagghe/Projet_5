<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/edit/{id}", name="editPost", methods={"POST", "GET"})
     * @Route("/admin/edit", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article = null, Request $request, ObjectManager $manager)
    {
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
            /*
            $article->setUser(App\Entity\Users::class 1);
            $article->addImg("https://img.surfsession.com/pictures/2017/20170111/thumbnail/1701112644.png");
            */
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