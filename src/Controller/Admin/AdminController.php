<?php

namespace App\Controller\Admin;

use App\Form\ArticleType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/edit", name="admin")
     */
    public function editPost(ObjectManager $manager, Request $request)
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
