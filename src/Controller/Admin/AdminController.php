<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Img;
use App\Form\ArticleType;
use App\Repository\ImgRepository;
use DateTime;
use DateTimeZone;
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
     * @Route("/{_locale}/admin/edit", requirements={"_locale": "fr|en"}, name="creatPost", methods={"POST", "GET"})
     */
    public function createPost(Article $article = null, Request $request, EntityManagerInterface $manager, Security $security)
    {
        if ($article == null){
            $article = new Article();
        }
        
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $now = new DateTime("now", new DateTimeZone("europe/rome"));
            $article->setUser($security->getUser())
                    ->setUpdatedAt($now);
            $manager->persist($article);
            $manager->flush();
            $n = $now->format('d/m/Y à H:i:s');
            $this->addFlash("success", 'Article crée le ' . $n);
                        
            return $this->redirectToRoute('editPost', [
                'format' => $article->getFormat(),
                'id' => $article->getId(),
                ]);
        }

        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'isMember' => $request->get('isMember'),
        ]);
    }

    /**
     * @Route("/{_locale}/admin/create-artist", requirements={"_locale": "fr|en"}, name="creatArtist", methods={"GET"})
     */
    public function createArtist()
    {
        return $this->redirectToRoute('creatPost', ['isMember' => true]);
    }

    /**
     * @Route("/{_locale}/admin/edit/{id}", requirements={"_locale": "fr|en"}, name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article, Request $request, EntityManagerInterface $manager, Security $security)
    {     
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $now = new DateTime("now", new DateTimeZone("europe/rome"));
            $article->setModifiedBy($security->getUser())
                    ->setUpdatedAt($now);
            $manager->persist($article);
            $manager->flush();
            
            $n = $now->format("d/m/Y - H:i:s");
            $this->addFlash("success", "Article enregistré le " . $n);
        }
        $isMember = false;
        if ($article->getFormat() === "members"){
            $isMember = true;
        }
        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'isMember' => $isMember,
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
        $idImg = $image->getId();
        if ($this->isCsrfTokenValid('delete.picture' . $idImg, $data['_token']))
        {
            try{
                $em->remove($image);
                $em->flush();
                return new JsonResponse(['success' => 1, 'idImg' => $idImg], 200);
            }catch(Exception $e){
                return new JsonResponse(['error' => 'Erreur lors du dialogue avec la base de donnée.'], 500);
            }
        }
        return new JsonResponse(['error' => 'Token invalide.'], 400);
    }

    /**
     * @Route("/admin/make-cover", name="makeCover", methods={"POST"})
     */
    public function makeCoverImage(Request $request, EntityManagerInterface $em, ImgRepository $image)
    {
        $imgId = json_decode($request->getContent(), true);
        try{
            $conn = $em->getConnection();
            $sql = 'UPDATE cdlmdb.img SET cover = false WHERE article_id = :id';
            $stmt = $conn->prepare($sql);
            $stmt->execute(["id" => $imgId["articleId"]]);
            
            $newCover = $image->find((int)$imgId["pictureId"]);
            $newCover->setCover(true);
            $em->persist($newCover);
            $em->flush();
            
            return new JsonResponse(['success' => true]);
        }catch(Exception $e){
            return new JsonResponse(['error' => 'Erreur lors du dialogue avec la base de donnée.' . $e], 500);
        }
    }
}