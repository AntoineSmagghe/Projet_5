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
    
    private $users;
    private $article;
    private $em;
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
     * @Route("/", name="home_public")
     */
    public function index()
    {
        if ($this->security->getUser() !== null) {
            $articles = $this->article->findAllDESC();

        } else {
            $articles = $this->article->takeAllExceptPrivateEvent();
        }
        
        return $this->render('home_public/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{format}", name="articles", methods={"GET"})
     */
    public function articles(Request $request)
    {
        $format = $request->get('format');
        $articles = $this->article->findAllByformat($format);

        return $this->render('home_public/articles.html.twig', [
            'articles' => $articles,
            'format' => $format
        ]);
    }
    
    /**
     * @Route("/article/{format}/{id}", name="article", methods={"GET"})
     */
    public function article(Request $request)
    {
        $res = $this->article->findOneBy(['id' => $request->get('id')]);
                
        return $this->render('home_public/article.html.twig', [
            'article' => $res,
        ]);
    }
}