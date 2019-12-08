<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Img;
use App\Form\ArticleType;
use DateTime;
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
    public function editPost(Article $article, Request $request, EntityManagerInterface $manager, Security $security)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article->setUpdatedAt(new DateTime("now"));
            $article->setModifiedBy($security->getUser());
            $manager->persist($article);
            $manager->flush();
                            
            return $this->redirectToRoute('article', [
                'format' => $article->getFormat(),
                'id' => $article->getId(),
                ]);
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
        if ($this->isCsrfTokenValid('delete.picture' . $image->getId(), $data['_token']))
        {
            try{
                $em->remove($image);
                $em->flush();
                return new JsonResponse(['success' => 1]);
            }catch(Exception $e){
                return new JsonResponse(['error' => 'Erreur lors du dialogue avec la base de donnée.'], 500);
            }
        }
        return new JsonResponse(['error' => 'Token invalide.'], 400);
    }
}