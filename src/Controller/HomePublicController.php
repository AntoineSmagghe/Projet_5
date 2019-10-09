<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UsersRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('home_public/index.html.twig', [
            'user' => $welcome
        ]);
    }

    /**
     * @Route("/article", name="article")
     */
    public function article()
    {
        $res = $this->article->find(1);
        dump($res);
        return $this->render('home_public/article.html.twig', [
            'article' => $res
        ]);
    }
}