<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Img;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/edit", name="creatPost", methods={"POST", "GET"})
     */
    public function createPost(Article $article = null, Request $request, EntityManagerInterface $manager, Security $security)
    {
        if ($article == null){
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
                
        if ($form->isSubmitted() && $form->isValid()){
            $article->setUser($security->getUser());
            $manager->persist($article);
            $manager->flush();
                        
            return $this->redirectToRoute('article', [
                'format' => $article->getFormat(), 
                'id' => $article->getId(),
                ]);
        }
        
        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()){
               $manager->persist($article);
               $manager->flush();
                              
               return $this->redirectToRoute('article', [
                   'format' => $article->getFormat(), 
                   'id' => $article->getId(),
                   ]);
           }else{
               throw new Exception("Le formulaire n'est pas valide.");
           }
        }
        
        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delPost", methods="DELETE")
     */
    public function delPost(Article $article, Request $request, EntityManagerInterface $manager)
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get("_token")))
        {
            $manager->remove($article);
            $manager->flush();
            return $this->redirectToRoute('articles', ['format' => $article->getFormat()]);
        }
    }

    /**
     * @Route("/admin/delete/image/{id}", name="delImg", methods="DELETE")
     */
    public function delImg(Img $image, Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $data['_token']))
        {
            try{
                dump($image->getName());
                $em->remove($image);
                $em->flush();
                return new JsonResponse(['success' => 1]);
            }catch(Exception $e){
                dump($e);
            }
        }
        return new JsonResponse(['error' => 'Token invalide.'], 400);
    }
}