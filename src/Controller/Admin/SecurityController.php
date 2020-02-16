<?php

namespace App\Controller\Admin;

use Exception;
use DateTime;

use App\Entity\Token;
use App\Entity\Users;
use App\Form\ResetMailType;
use App\Form\ResetPasswordType;
use App\Form\TokenSinginType;
use App\Form\UserIdentityType;
use App\Form\UsersType;
use App\Repository\TokenRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address as MimeAddress;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $em;
    private $trans;
    private $mi;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $trans, MailerInterface $mi)
    {
        $this->em = $em;
        $this->trans = $trans;
        $this->mi = $mi;
    }
    
    /**
     * @Route("/{_locale}/connexion", requirements={"_locale": "fr|en"}, name="login", methods={"POST", "GET"})
     */
    public function login(AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastName = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_user' => $lastName,
            'error' => $error
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout(){}

    /**
     * @Route("/{_locale}/admin/signin", requirements={"_locale": "fr|en"}, name="signIn", methods={"POST", "GET"})
     */
    public function adminSignin(Request $request, TranslatorInterface $trans, MailerInterface $mi)
    {
        $newUser = new Users();
        $form = $this->createForm(UsersType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $newUser->getConfirmPassword();
            $bcryptPass = password_hash($newUser->getPassword(), PASSWORD_BCRYPT);
            $newUser->setPassword($bcryptPass)
                    ->setLastLog(new DateTime())
                    ->setCreatedAt(new DateTime());

            $this->em->persist($newUser);
            $this->em->flush();
            $this->addFlash('success', $trans->trans("Le membre a bien été enregistré en base de données."));
            
            $email = (new TemplatedEmail())
                ->from(new MimeAddress('cdlm.free@gmail.com', "Le Chant de la Machine"))
                ->to($newUser->getMail())
                ->subject('Hello !')
                ->htmlTemplate('mailer/signin.html.twig')
                ->context([
                    'user' => $newUser,
                    'plainPassword' => $plainPassword,
                ]);
            $this->mi->send($email);
            $this->addFlash('success', $this->trans->trans("Un mail lui a été envoyé."));
            
            return $this->redirectToRoute("signIn");
        }

        return $this->render('admin/signin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{_locale}/signin/", requirements={"_locale": "fr|en"}, name="tokenSignin", methods={"POST", "GET"})
     */
    public function signin(TokenRepository $tokenRepository, Request $request)
    {
        $token = $tokenRepository->findOneBy(["token" => $request->get("t"), "used" => false]);
        if ($token != null){
            $user = new Users();
            $form = $this->createForm(TokenSinginType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $plainPassword = $user->getConfirmPassword();
                $bcryptPass = password_hash($user->getPassword(), PASSWORD_BCRYPT);

                $user->setPassword($bcryptPass)
                    ->setLastLog(new DateTime('now'))
                    ->setCreatedAt(new DateTime('now'));

                $this->em->persist($user);
                
                $token->setUsed(true);
                $this->em->persist($token);
                $this->em->flush();
                
                $email = (new TemplatedEmail())
                ->from(new MimeAddress('cdlm.free@gmail.com', "Le Chant de la Machine"))
                ->to($user->getMail())
                ->subject('Welcome !')
                ->htmlTemplate('mailer/signin.html.twig')
                ->context([
                    'user' => $user,
                    'plainPassword' => $plainPassword,
                    ])
                    ;
                $this->mi->send($email);
                    
                $this->addFlash('success', $this->trans->trans("Welcome! You are now registred as a member on CDLM.space"));

                return $this->redirectToRoute("login");
            }

            return $this->render("security/tokenSignin.html.twig", [
                'form' => $form->createView(),
            ]);
        }

        $this->addFlash("fail", $this->trans->trans("Wrong token or already use"));
        return $this->redirectToRoute("home_public");
    }

    /**
     * @Route("/{_locale}/users/account", requirements={"_locale": "fr|en"}, name="account", methods={"POST", "GET"})
     */
    public function account()
    {
        return $this->render('users/account.html.twig', [
            'user' => $this->getUser(),
        ]);
    }


    /**
     * @Route("/{_locale}/users/reset-name", requirements={"_locale": "fr|en"}, name="resetName", methods={"POST", "GET"})
     */
    public function resetName(EntityManagerInterface $manager, Request $request, TranslatorInterface $trans)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserIdentityType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', $trans->trans("Les changements ont bien été enregistrés en base de données."));
            return $this->redirectToRoute("account");
        }

        return $this->render('users/reset_name.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{_locale}/users/reset-password", requirements={"_locale": "fr|en"}, name="resetPassword", methods={"POST", "GET"})
     */
    public function resetPassword(UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $em, TranslatorInterface $trans)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($passwordEncoder->isPasswordValid($user, $request->request->get('reset_password')['oldPassword'])){
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getResetPassword());
                $user->setPassword($newEncodedPassword);
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', $trans->trans("Votre mot de passe à bien été changé !"));
                return $this->redirectToRoute('account');
            } else {
                $this->addFlash('fail', $trans->trans('Ancien mot de passe incorrect'));
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('users/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{_locale}/users/reset-email", requirements={"_locale": "fr|en"}, name="resetMail", methods={"POST", "GET"})
     */
    public function resetMail(Request $request, EntityManagerInterface $manager, TranslatorInterface $trans)
    {
        $user = $this->getUser();
        $form = $this->createForm(ResetMailType::class, $user);
        $form->handleRequest($request);
        try{
            if ($form->isSubmitted() && $form->isValid()){
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', $trans->trans('Votre adresse mail a bien été changée !'));
                return $this->redirectToRoute('account');
            }
        } catch(Exception $e){
            $this->addFlash('fail', $e);
        }
        return $this->render('users/reset_mail.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
