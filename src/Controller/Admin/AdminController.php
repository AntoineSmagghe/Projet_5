<?php

namespace App\Controller\Admin;

use DateTime;
use DateTimeZone;
use Exception;
use App\Entity\Article;
use App\Entity\Img;
use App\Entity\Token;
use App\Form\ArticleType;
use App\Repository\ImgRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Translatable\Entity\Translation;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{
    private $em;
    private $mi;
    private $trans;

    public function __construct(EntityManagerInterface $em, MailerInterface $mi, TranslatorInterface $trans)
    {
        $this->em = $em;
        $this->mi = $mi;
        $this->trans = $trans;
    }

    /**
     * @Route("/{_locale}/admin/edit", requirements={"_locale": "fr|en"}, name="creatPost", methods={"POST", "GET"})
     */
    public function createPost(Request $request, EntityManagerInterface $manager, Security $security, TranslatorInterface $translator)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $now = new DateTime("now", new DateTimeZone("europe/rome"));
            $article->setTranslatableLocale($request->getLocale())
                    ->setUser($security->getUser())
                    ->setUpdatedAt($now);
            $manager->persist($article);
            $manager->flush();
            
            $this->addFlash("success", $translator->trans("Article created at") . " " . $now->format('d/m/Y - H:i:s'));
            
            return $this->redirectToRoute('editPost', [
                'format' => $article->getFormat(),
                'id' => $article->getId(),
                ]);
        }

        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'isMember' => $request->get('isMember'),
        ]);
    }

    /**
     * @Route("/{_locale}/admin/create-artist", requirements={"_locale": "fr|en"}, name="creatArtist", methods={"GET"})
     */
    public function createArtist()
    {
        return $this->redirectToRoute('creatPost', ['isMember' => true]);
    }

    /**
     * @Route("/{_locale}/admin/edit/{id}", requirements={"_locale": "fr|en"}, name="editPost", methods={"POST", "GET"})
     */
    public function editPost(Article $article, Request $request, EntityManagerInterface $manager, Security $security, TranslatorInterface $translator)
    {
        $article->setTranslatableLocale($request->getLocale());
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $now = new DateTime("now", new DateTimeZone("europe/rome"));
            $article->setModifiedBy($security->getUser())
                ->setUpdatedAt($now)
                ;
            $manager->persist($article);
            $manager->flush();

            $this->addFlash("success", $translator->trans("Article record at") . " " . $now->format('d/m/Y - H:i:s'));
        }

        $isMember = false;
        if ($article->getFormat() === "members"){
            $isMember = true;
        }

        $repo = $manager->getRepository(Translation::class);
        $translation = $repo->findTranslations($article);

        if (isset($translation[$request->getLocale()])) {
            if (!empty($translation[$request->getLocale()]["text"])) {
                $text = $translation[$request->getLocale()]["text"];
            } else {
                $text = $translation['fr']["text"];
            }
        } else {
            $text = $article->getText();
        }

        return $this->render('admin/edit_post.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'text' => $text,
            'isMember' => $isMember,
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delPost", methods="DELETE")
     */
    public function delPost(Article $article, Request $request, EntityManagerInterface $manager)
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->get("_token")))
        {
            $manager->remove($article);
            $manager->flush();
            return $this->redirectToRoute('articles', ['format' => $article->getFormat()]);
        }
    }

    /**
     * @Route("/admin/delete/image/{id}", name="delImg", methods="DELETE")
     */
    public function delImg(Img $image, Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $idImg = $image->getId();
        if ($this->isCsrfTokenValid('delete.picture' . $idImg, $data['_token']))
        {
            try{
                $em->remove($image);
                $em->flush();
                return new JsonResponse(['success' => 1, 'idImg' => $idImg], 200);
            }catch(Exception $e){
                return new JsonResponse(['error' => 'Erreur lors du dialogue avec la base de donnée.'], 500);
            }
        }
        return new JsonResponse(['error' => 'Token invalide.'], 400);
    }

    /**
     * @Route("/admin/make-cover", name="makeCover", methods={"POST"})
     */
    public function makeCoverImage(Request $request, EntityManagerInterface $em, ImgRepository $image)
    {
        $imgId = json_decode($request->getContent(), true);
        try{
            $conn = $em->getConnection();
            $sql = 'UPDATE cdlmdb.img SET cover = false WHERE article_id = :id';
            $stmt = $conn->prepare($sql);
            $stmt->execute(["id" => $imgId["articleId"]]);
            
            $newCover = $image->find((int)$imgId["pictureId"]);
            $newCover->setCover(true);
            $em->persist($newCover);
            $em->flush();
            
            return new JsonResponse(['success' => true]);
        }catch(Exception $e){
            return new JsonResponse(['error' => 'Erreur lors du dialogue avec la base de donnée.' . $e], 500);
        }
    }

    /**
     * @Route("{_locale}/admin/sending-inscriptions", name="sendInscriptions", requirements={"_locale": "fr|en"})
     */
    public function sendingInscriptions(Request $request)
    {
        $formBuilder = $this->createFormBuilder();
        $formBuilder->add('emails', CollectionType::class, [
                'allow_delete' => true,
                'delete_empty' => true,
                'allow_add' => true,
                'entry_type' => EmailType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'adresse membre',
                        'placeholder' => 'Une adresse mail',
                    ]
                ]
            ])
            ->add('submit', SubmitType::class);

        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->attributeTokenToEmails($form->getData()["emails"]);
        }
        
        return $this->render("admin/sendingInscriptions.html.twig", [
            "form" => $form->createView(),
        ]);
    }
    
    private function attributeTokenToEmails($emails)
    {
        for ($i = 0; $i < count($emails); $i++) {
            $tokenEntity = new Token();
            $token = bin2hex(random_bytes(26));
            $url = $this->generateUrl("tokenSignin", ["t" => $token]);

            $tokenEntity->setEmail($emails[$i])
                ->setToken($token)
                ->setDate(new DateTime('now'))
                ->setLink($url);
            $this->em->persist($tokenEntity);
            $this->em->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('cdlm.free@gmail.com', "Le Chant de la Machine"))
                ->to($emails[$i])
                ->subject('Hello !')
                ->htmlTemplate('mailer/sendTokenForSignin.html.twig')
                ->context([
                    'url' => $url,
                    'personalEmail' => $emails[$i],
                ]);

            $this->mi->send($email);
        }

        return $this->addFlash('success', $this->trans->trans("Les mails ont été envoyés"));
    }
}