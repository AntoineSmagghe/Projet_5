<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Img;
use App\Form\ArticleType;
use App\Repository\ImgRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/edit", name="creatPost", methods={"POST", "GET"})
     * @Route("/admin/edit/{id}", name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article = null, Request $request, ObjectManager $manager, Security $security)
    {
        if ($article === null){
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);           
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
                        
            $article->setCreatedAt(new DateTime())
                ->setUser($security->getUser());

            /**
             * @var UploadedFiles $imgs 
             */
            $imgs = $form['imgs']->getData();

            if ($imgs){
                
                $originalName = pathinfo($imgs->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalName);
                $uniqueName = $safeName . "-" . uniqid() . "." . $imgs->guessExtension();
                
                try
                {
                    $imgs->move($this->getParameter('picture_directory'), $uniqueName);
                }
                catch (FileException $e)
                {
                    dump($e);
                }
                
                $imgObj = new Img();

                $imgObj->setName($uniqueName);

                dump($imgObj);

                $article->addImg($imgObj);

                $manager->persist($article);

                $manager->flush();

                return $this->redirect($this->generateUrl("picture_directory"));
            }
            

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
        if (!$systemfile->exists(sys_getloadavg(). "public/upload/pictures"))
        {
            $systemfile->mkdir(sys_get_temp_dir(). "public/upload/pictures", 0775);
        }
       
    }
}