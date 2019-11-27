<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Img;
use App\Form\ArticleType;
use App\Service\Uploader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/edit", name="creatPost", methods={"POST", "GET"})
     * @Route("/admin/edit/{id}", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article = null, Request $request, ObjectManager $manager,Uploader $uploader, Security $security)
    {
        if ($article === null){
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            if ($article->getImgsFile() instanceof UploadedFile){
                
                /**
                 * @var UploadedFile $imgs
                 */
                $imgs = $form['imgsFile']->getData();

                foreach ($images as $imgs){
                    $imgName = $uploader->upload($imgs);
                    $imgObj = new Img();
                    $imgObj->setName($imgName);
                    $manager->persist($imgObj);
                    $article->addImg($imgObj);
                }
            }
            

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
     * @Route("/admin/delete/{id}", name="delPost", methods="DELETE")
     */
    public function delPost(Article $article, Request $request, ObjectManager $manager)
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
    public function delImg(Img $image, Request $request, ObjectManager $manager)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete', $image->get('id'), $data['_token']))
        {
            $manager->remove($image);
            $manager->flush();
            return new JsonResponse(['success' => 1]);
        }
        return new JsonResponse(['error' => 'Token invalide.'], 400);
    }
}