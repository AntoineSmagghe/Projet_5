<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Users;
use App\Form\ResetMailType;
use App\Form\ResetPasswordType;
use App\Form\UserIdentityType;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address as MimeAddress;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
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
    public function signIn(EntityManagerInterface $manager, Request $request, TranslatorInterface $trans, MailerInterface $mi)
    {
        $newUser = new Users();
        $form = $this->createForm(UsersType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bcryptPass = password_hash($newUser->getPassword(), PASSWORD_BCRYPT);
            $newUser->setPassword($bcryptPass)
                    ->setLastLog(new DateTime())
                    ->setCreatedAt(new DateTime());

            $manager->persist($newUser);
            $manager->flush();
            $this->addFlash('success', $trans->trans("Le membre a bien été enregistré en base de données."));

            $email = (new TemplatedEmail())
                ->from(new MimeAddress('cdlm.free@gmail.com', "Le Chant de la Machine"))
                ->to($newUser->getMail())
                ->subject('Hello !')
                ->htmlTemplate('mailer/signin.html.twig')
                ->context([
                    'user' => $newUser,
                ]);
            $mi->send($email);

            return $this->redirectToRoute("signIn");
        }

        return $this->render('admin/signin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{_locale}/users/account", requirements={"_locale": "fr|en"}, name="account", methods={"POST", "GET"})
     */
    public function account(EntityManagerInterface $manager, Request $request, TranslatorInterface $trans)
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

        return $this->render('users/account.html.twig', [
            'user' => $this->getUser(),
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


    /**
     * @Route("/admin/send_mail")
     */
    public function sendTestMail(Security $security)
    {
        $gmail = new GmailSmtpTransport('cdlm.free@gmail.com', 'Saperlipopette01');
        $mailer = new Mailer($gmail);

        $user = $security->getUser();
        $email = (new TemplatedEmail())
            ->from(new MimeAddress('cdlm.free@gmail.com', "Le Chant de la Machine"))
            ->to($user->getMail())
            ->subject('Hello !')
            ->htmlTemplate('mailer/signin.html.twig')
            ->context([
                'user' => $user,
            ]);
        $mailer->send($email);
        return $this->render("Mail Sended");
    }
}
