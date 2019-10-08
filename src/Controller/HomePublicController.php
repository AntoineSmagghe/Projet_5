<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePublicController extends AbstractController
{
    /**
     * @Route("/", name="home_public")
     */
    public function index()
    {
        return $this->render('home_public/index.html.twig');
    }
}
