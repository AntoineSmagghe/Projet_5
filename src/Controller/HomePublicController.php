<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ImgRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomePublicController extends AbstractController
{
    private $article;
    private $security;
    private $imgRepo;
    
    public function __construct(Security $security, UsersRepository $users, ArticleRepository $article, ImgRepository $imgRepo)
    {
        $this->security = $security;
        $this->article = $article;
        $this->users = $users;
        $this->imgRepo = $imgRepo;
    }


    /**
     * @Route("/")
     */
    public function localRedirect()
    {
        return $this->redirectToRoute('home_public');
    }

    /**
     * @Route("/{_locale}/", name="home_public", requirements={"_locale": "fr|en"})
     */
    public function index()
    {
        if ($this->security->getUser() !== null) {
            $articles = $this->article->findAllDESC();
        } else {
            $articles = $this->article->takeAllExceptprivateEvent();
        }
        $covers = $this->getCovers($articles);
        return $this->render('home_public/index.html.twig', [
            'articles' => $articles,
            'covers' => $covers,
        ]);
    }

    /**
     * @Route("/{_locale}/article/{format}", requirements={"_locale": "fr|en"}, name="articles", methods={"GET"})
     */
    public function articles(Request $request)
    {
        $format = $request->get('format');
        $articles = $this->article->findAllByformat($format);
        $covers = $this->getCovers($articles);
        if ($format === 'members'){
            return $this->render('home_public/members.html.twig', [
                'articles' => $articles,
                'format' => $format,
                'covers' => $covers,
            ]);
        }

        if ($format === 'releases') {
            return $this->render('home_public/releases.html.twig', [
                'articles' => $articles,
                'format' => $format,
                'covers' => $covers,
            ]);
        }

        return $this->render('home_public/articles.html.twig', [
            'articles' => $articles,
            'format' => $format,
            'covers' => $covers,
        ]);
    }

    /**
     * @Route("/{_locale}/article/{format}/{slug}", requirements={"_locale": "fr|en"}, name="article", methods={"GET"})
     */
    public function article(Request $request)
    {
        $article = $this->article->findOneBy(['slug' => $request->get('slug')]);
        $imageCover = $this->imgRepo->findOneBy(["cover" => true, "article" => $article->getId()]);

        if ($article->getFormat() === "members"){
            return $this->render('home_public/member.html.twig', [
                'article' => $article,
                'cover' => $imageCover,
            ]);
        }

        if ($article->getFormat() === "releases") {
            return $this->render('home_public/release.html.twig', [
                'article' => $article,
                'cover' => $imageCover,
            ]);
        }

        return $this->render('home_public/article.html.twig', [
            'article' => $article,
            'cover' => $imageCover,
        ]);
    }

    /**
     * @Route("/{_locale}/legals", requirements={"_locale": "fr|en"}, name="legals", methods={"GET"})
     */
    public function showLegals()
    {
        return $this->render("legals/legals.html.twig");
    }

    private function getCovers($articles)
    {
        $covers = [];
        for($i=0; $i < count($articles); $i++){
            $cover = $this->imgRepo->findOneBy([
                "cover" => true, 
                "article" => $articles[$i]->getId()
                ]);

            if ($cover != null){
                $cover = $cover->getName();
                $covers[$i] = [
                    "idArticle" => $articles[$i]->getId(),
                    "covername" => $cover,
                ];
            }
        }
        
        return $covers;
    }
}