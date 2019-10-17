<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function editPost(ObjectManager $manager, Request $request)
    {
        $article = new Article();
        $article->setText('J\'aime le texte!')
            ->setTitle('j\'aime les titres')
            ->setDateEvent(new DateTime('tomorrow'));

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
