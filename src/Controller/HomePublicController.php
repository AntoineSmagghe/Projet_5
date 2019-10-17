<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UsersRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomePublicController extends AbstractController
{
    private $users;
    private $article;
    
    public function __construct(UsersRepository $users,ArticleRepository $article, ObjectManager $em)
    {
        $this->article = $article;
        $this->users = $users;
        $this->em = $em;
    }

    /**
     * @Route("/", name="home_public")
     */
    public function index()
    {
        $res = $this->users->findAll(1);
        $welcome = $res[0];

        $articles = $this->article->findAll();
        dump($articles);

        return $this->render('home_public/index.html.twig', [
            'user' => $welcome,
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{format}", name="articles", methods={"GET"})
     */
    public function articles(Request $request)
    {
        $format = $request->get('format');
        $res = $this->article->findAllByformat($format);
        return $this->render('home_public/articles.html.twig', [
            'articles' => $res,
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
            'article' => $res
        ]);
    }
}