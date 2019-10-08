<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePublicController extends AbstractController
{
    private $repo;
    
    public function __construct(UsersRepository $repo, ObjectManager $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/", name="home_public")
     */
    public function index()
    {
        $res = $this->repo->findAll(1);
        $welcome = $res[0];
        return $this->render('home_public/index.html.twig', [
            'whoisboss' => $welcome
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article", requirements={ "slug" : "[a-z0-9\-]*"})
     */
    public function article()
    {
        return $this->render('home_public/article.html.twig', [
            'infos' => 'Hello la compagnie'
        ]);
    }
}