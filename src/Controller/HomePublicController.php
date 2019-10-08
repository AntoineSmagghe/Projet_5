<?php

namespace App\Controller;

use App\Entity\Users;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePublicController extends AbstractController
{
    /**
     * @Route("/", name="home_public")
     */
    public function index()
    {
        /*
        $user = new Users();
        $user->setSurname('Antoine')
        ->setName('Smagghe')
        ->setMail('antoine@smagghe.me')
        ->setIsAdmin(true)
        ->setPassword(' ')
        ->setLastLog(new DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        */

        $repo = $this->getDoctrine()->getRepository(Users::class);
        $res = $repo->find(1);
        $name = $res['surname'];
        
        return $this->render('home_public/index.html.twig', [
            'whoisboss' => $name
            ]);
    }
}