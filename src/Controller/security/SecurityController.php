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
use App\Repository\user\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    
    /**
     * User registration
     * 
     * @Route("/security/registration", name="security.registration")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param AuthorizationCheckerInterface $authChecker
     * @param \Swift_Mailer $mailer
     * @param UserRepository $userRepository
     * 
     * @return Response
     */
     public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, 
                                  AuthorizationCheckerInterface $authChecker, \Swift_Mailer $mailer, UserRepository $userRepository): Response
    {

        $administrator = $userRepository->findOneBy(array('name' => 'administrator'));

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
                     ->setSender($administrator)
                     ->setMessage('Account creation')
                     ->setBody($this->renderView(
                                                    'security/registrationEmail.html.twig', 
                                                    ['user' => $user]
                                                )
                              )
                ;

                if ($mail->sendEmail($mailer))
                {                

                    $manager->persist($mail);
                    $manager->flush();

                    $this->addFlash('success', "An email was sent to the completed email address to activate your account.");

                }
                else
                {

                    $this->addFlash('error', "An email could not be sent to the completed email address to activate your account.");

                }

            }

        }

        return $this->render('security/registration.html.twig', [
                                                                    'current_menu' => 'registration',
                                                                    'form' => $form->createView()
                                                                ]
                            )
        ;

    }

    /**
     * User activation
     * 
     * @Route("/security/confirmation/{id}", name="security.confirmation")
     *
     * @param User $user
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function registrationActivation(User $user, ObjectManager $manager): Response
    {

        $user->setIsActive(true);
            
        $manager->persist($user);
        $manager->flush(); 

        $token = new UsernamePasswordToken(
                                            $user,
                                            $user->getPassword(),
                                            'main',
                                            $user->getRoles()
                                          )
        ;
        
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        $this->addFlash('success', 'Your account was successfully activated.');
        
        return $this->redirectToRoute('user.dashboard');
    
    }

    /**
     * User login
     * 
     * @Route("/security/login", name="security.login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) 
        {

            return $this->redirectToRoute('user.dashboard');

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
     * User logout
     * 
     * @Route("/security/logout", name="security.logout")
     *
     * @return void
     */
    public function logout()
    {
    }

    /**
     * User request to change its password
     * 
     * @Route("/security/resetting/request", name="security.resetting.request")
     *
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param ObjectManager $manager
     * @param UserRepository $userRepository
     * 
     * @return Response
     */
    public function resetingRequest(Request $request, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator, ObjectManager $manager, 
                                    UserRepository $userRepository): Response
    {

        $administrator = $userRepository->findOneBy(array('name' => 'administrator'));

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

            $user = $manager->getRepository(User::class)->loadUserByEmail($form->getData()['email']);

            if (! $user) 
            {

                $this->addFlash('warning', "The email address isn't linked to a Roadtrip user.");

                return $this->redirectToRoute("security.resetting.request");

            }
            else
            { 

                $user->setToken($tokenGenerator->generateToken());
                $user->setPasswordRequestedAt(new \Datetime());
                $manager->flush(); 

                $mail = new Mail;

                $mail->setReceiver($user)
                    ->setSubject($this->getParameter('password_Resetting_email_subject'))
                    ->setSender($administrator)
                    ->setMessage('Password renew')
                    ->setBody($this->renderView(
                                                    'security/passwordResettingEmail.html.twig', 
                                                    ['mail' => $mail]
                                                )
                                )
                ;

                if ($mail->sendEmail($mailer))
                { 
                    
                    $manager->persist($mail);
                    $manager->flush();
                    
                    $this->addFlash('success', "An email has been sent to the registered email address in your account so you can change your password.");
                    
                    return $this->redirectToRoute("security.login");

                }
                else
                {

                    $this->addFlash('warning', "Impossible to send a confirmation email to change your password.");

                    return $this->redirectToRoute("security.resetting.request");

                }

            }

        }

        return $this->render('security/passwordResettingRequest.html.twig', ['form' => $form->createView()]);

    }

    /**
     * User password update from the forgotten password functionality
     * 
     * @Route("security/resetting/{id}/{token}", name="security.resetting")
     *
     * @param User $user
     * @param [type] $token
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function resetting(User $user, $token, Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager): Response
    {
        // Prohibited access if:
        // the user token is null
        // the database token and the url token are not equals
        // the token is older than 10 minutes

        if ($user->getToken() === null || $token !== $user->getToken() || !$this->isRequestInTime($user->getPasswordRequestedAt()))
        {

            throw new AccessDeniedHttpException();

        }
        
        return $this->passwordUpdating($user, $request, $encoder, $manager);
        
    }

    /**
     * User password update from the dashboard
     * 
     * @Route("security/resetting/dashboard", name="security.resetting.dashboard")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $manager
     * 
     * @return void
     */
    public function resettingDashboard(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager)
    {

        $user = $this->getUser();
        
        return $this->passwordUpdating($user, $request, $encoder, $manager);
        
    }
            
    /**
     * Return if the password change is over than 10 minutes after the token creation
     *
     * @param \Datetime $passwordRequestedAt
     * 
     * @return boolean
     */
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
            
    /**
     * User password Update function
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    private function passwordUpdating(User $user, Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager): Response
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

            if ($this->isGranted('ROLE_USER')) 
            {

                return $this->redirectToRoute('user.dashboard');

            }
            else
            {

                return $this->redirectToRoute('security.login');

            }

        }

        return $this->render('security/passwordResetting.html.twig', ['form' => $form->createView()]);

    }

}
