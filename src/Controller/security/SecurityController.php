<?php

namespace App\Controller\security;

use App\Entity\user\User;
use App\Form\user\UserType;
use App\Entity\communication\Mail;
use App\Form\security\PasswordResettingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends AbstractController
{
    
    /**
     * @Route("/security/registration", name="security.registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker, \Swift_Mailer $mailer)
    {

        $user = new User;
        $isAdmin = $authChecker->isGranted('ROLE_ADMIN');
        
        $form = $this->createForm(UserType::class, $user, array('isAdmin' => $isAdmin));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {                       

            $password = $user->getPassword();
            
            if ($password != $user->getConfirmedPassword()) 
            {

                $this->addFlash('error', "The password and the password confirmation are different.");

            }
            else
            {
            
                $hash = $encoder->encodePassword($user, $password);

                $user->setPassword($hash);  

                if (! $isAdmin)
                {

                    $user->setRoles(['ROLE_USER']);

                }

                $manager->persist($user);
                $manager->flush(); 

                $mail = new Mail;

                $mail->setReceiver($user)
                    ->setSubject($this->getParameter('registration_email_subject'))
                    ->setFirstname($this->getParameter('administrateur_firstname'))
                    ->setName($this->getParameter('administrateur_name'))
                    ->setEmailFrom($this->getParameter('administrateur_email'))
                    ->setTemplate('security/registrationEmail.html.twig')
                    ->setMessage($this->renderView(
                                                    $mail->getTemplate(), 
                                                    ['user' => $user]
                                                )
                                )
                ;

                if ($mail->sendEmail($mailer))
                {                

                    $manager->persist($mail);
                    $manager->flush();

                    $this->addFlash('success', "An email was sended to the completed email address to activate your account.");

                }
                else
                {

                    $this->addFlash('error', "An email could not be sent to the completed email address to activate your account.");

                }

            }

        }

        return $this->render('Security/registration.html.twig', [
                                                                    'current_menu' => 'registration',
                                                                    'form' => $form->createView()
                                                                ]
                            )
        ;

    }

    /**
     * @Route("/security/confirmation/{id}", name="security.confirmation")
     */
    public function registrationActivation(User $user, ObjectManager $manager)
    {

        $user->setIsActive(true);
            
        $manager->persist($user);
        $manager->flush(); 

        $token = new UsernamePasswordToken(
            $user,
            $user->getPassword(),
            'main',
            $user->getRoles()
        );
        
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
        
        return $this->redirectToRoute('user.dashbord');
    
    }

    /**
     * @Route("/security/login", name="security.login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) 
        {

            return $this->redirectToRoute('user.dashbord');

        }
        
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
                                                            'last_username' => $lastUsername,
                                                            'current_menu' => 'login', 
                                                            'error' => $error,
                                                         ]
                            )
        ;

    }

    /**
     * @Route("/security/logout", name="security.logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/security/resetting/request", name="security.resetting.request")
     */
    public function resetingRequest(Request $request, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator, ObjectManager $manager)
    {
        $form = $this->createFormBuilder()
                     ->add('email', EmailType::class, ['constraints' => [
                                                                            new Email(),
                                                                            new NotBlank()
                                                                        ]
                                                      ]
                          )
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $user = $manager->getRepository(User::class)->loadUserByUsername($form->getData()['email']);

            if (!$user) 
            {

                $this->addFlash('warning', "The email address isn't linked with a Roadtrip user.");
                return $this->redirectToRoute("security.resetting");

            } 

            $user->setToken($tokenGenerator->generateToken());
            $user->setPasswordRequestedAt(new \Datetime());
            $manager->flush(); 

            $mail = new Mail;

            $mail->setReceiver($user)
                 ->setSubject($this->getParameter('password_Resetting_email_subject'))
                 ->setFirstname($this->getParameter('administrateur_firstname'))
                 ->setName($this->getParameter('administrateur_name'))
                 ->setEmailFrom($this->getParameter('administrateur_email'))
                 ->setTemplate('security/passwordResettingEmail.html.twig')
                 ->setMessage($this->renderView(
                                                $mail->getTemplate(), 
                                                ['user' => $user]
                                               )
                             )
            ;

            if ($mail->sendEmail($mailer))
            { 
                
                $this->addFlash('success', "An email has been sent to the registered email address in your account so you can change your password.");
                
                return $this->redirectToRoute("security.login");

            }
            else
            {

                $this->addFlash('warning', "Impossible to send a confirmation email to change your password.");

            }

        }

        return $this->render('security/passwordResettingRequest.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("security/resetting/{id}/{token}", name="security.resetting")
     */
    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {
        // Prohibited access if:
        // the user token is null
        // the database token and the url token are not equals
        // the token is older than 10 minutes

        if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
        {

            throw new AccessDeniedHttpException();

        }
        
        $route = 'security.login';
        
        return $this->passwordUpdating($user, $request, $encoder, $manager, $route);
        
    }

    /**
     * @Route("security/resetting/dashbord", name="security.resetting.dashbord")
     */
    public function resettingDashbord(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {

        $user = $this->getUser();
        $route = 'user.dashbord';
        
        return $this->passwordUpdating($user, $request, $encoder, $manager, $route);
        
    }
            
    // If over 10 min, false returned
    private function isRequestInTime(\Datetime $passwordRequestedAt = null)
    {
        if ($passwordRequestedAt === null)
        {

            return false; 

        }
        
        $now = new \DateTime();
        $interval = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        $daySeconds = 60 * 10;
        $response = $interval > $daySeconds ? false : $reponse = true;

        return $response;

    }
            
    // If over 10 min, false returned
    private function passwordUpdating($user, $request, $encoder, $manager)
    {

        $form = $this->createForm(PasswordResettingType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {                       

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            // Token reinitialisation to null to be not reusable
            $user->setToken(null);
            $user->setPasswordRequestedAt(null);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "Your password has been renewed.");

            return $this->redirectToRoute('user.dashbord');

        }

        return $this->render('security/passwordResetting.html.twig', ['form' => $form->createView()]);

    }

}
