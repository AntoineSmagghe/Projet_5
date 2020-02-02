<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\ImgRepository;
use App\Repository\UsersRepository;
use Symfony\Bridge\Monolog\Handler\SwiftMailerHandler;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Address;
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
            return $this->render('articles/members.html.twig', [
                'articles' => $articles,
                'format' => $format,
                'covers' => $covers,
            ]);
        }

        if ($format === 'releases') {
            return $this->render('articles/releases.html.twig', [
                'articles' => $articles,
                'format' => $format,
                'covers' => $covers,
            ]);
        }

        return $this->render('articles/articles.html.twig', [
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
            return $this->render('article/member.html.twig', [
                'article' => $article,
                'cover' => $imageCover,
            ]);
        }

        if ($article->getFormat() === "releases") {
            return $this->render('article/release.html.twig', [
                'article' => $article,
                'cover' => $imageCover,
            ]);
        }

        return $this->render('article/article.html.twig', [
            'article' => $article,
            'cover' => $imageCover,
        ]);
    }

    /**
     * @Route("/{_locale}/about", name="about", requirements={"_locale": "fr|en"}, methods={"POST", "GET"})
     */
    public function about(Request $request, MailerInterface $mailerInterface)
    {
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()){
/*    
            $email = (new TemplatedEmail())
                ->from(new Address('cdlm.free@gmail.com', $contact->getEmail()))
                ->to(new Address('cdlm.free@gmail.com'))
                ->subject("Message de " . $contact->getSurname() . " " . $contact->getName())
                ->htmlTemplate('mailer/contactForm.html.twig')
                ->context([
                    'contact' => $contact,
                ])
                ;
            $mailerInterface->send($email);
*/

            $this->addFlash('info', 'Email envoyé! Nous reviendrons vers toi au plus vite.');
        }
        
        return $this->render('about/about.html.twig', [
            'form' => $contactForm->createView(),
        ]);
    }

    /**
     * @Route("/{_locale}/legals", requirements={"_locale": "fr|en"}, name="legals", methods={"GET"})
     */
    public function showLegals()
    {
        return $this->render("legals/legals.html.twig");
    }

    /**
     * @Route("/{_locale}/rgpd", requirements={"_locale": "fr|en"}, name="rgpd", methods={"GET"})
     */
    public function showRGPD()
    {
        return $this->render("legals/rgpd.html.twig");
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
                $covers[$i] = [
                    "idArticle" => $articles[$i]->getId(),
                    "covername" => $cover->getName(),
                ];
            }
        }

        return $covers;
    }
}