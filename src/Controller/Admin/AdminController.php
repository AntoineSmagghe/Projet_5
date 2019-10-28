<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/edit", name="creatPost", methods={"POST", "GET"})
     * @Route("/admin/edit/{id}", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article = null, ArticleRepository $articleRepository, Request $request, ObjectManager $manager, Security $security)
    {
        if ($article === null){
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);           
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
                        
            $article->setCreatedAt(new DateTime());
            $article->setUser($security->getUser());

            //$article->addImg("https://img.surfsession.com/pictures/2017/20170111/thumbnail/1701112644.png");
            
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

    private function savePicture()
    {
        $systemfile = new Filesystem();
        if (!$systemfile->exists(sys_get_temp_dir()."/uploaded_pictures"))
        {
            $systemfile->mkdir(sys_get_temp_dir(). "/uploaded_pictures", 0775);
        }
       
    }
}