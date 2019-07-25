<?php

namespace App\Controller\user;

use App\Entity\user\User;
use App\Form\user\EditUserType;
use App\Repository\user\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserUserController extends AbstractController
{
    
    /**
     * @Route("/user/users", name="user.user.index")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
     
        $users = $userRepository->findAll();
    
        return $this->render('user/index.html.twig', compact('users'));  
        
    }

    /**
     * @Route("/user/user/edit", name="user.user.edit")
     * @param User $user
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Request $request, ObjectManager $manager): Response
    {       
        
        $user = $this->getUser();
        
        $form = $this->createForm( EditUserType::class, $user, array('isAdmin' => false) );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())   
        {                         

            $manager->flush(); 

            $this->addFlash('success', "Your profile has been changed successfully.");

            return $this->redirectToRoute('user.dashbord');

        }
     
        return $this->render('user/edit.html.twig', [
                                                        'user' => $user,
                                                        'form' => $form->createView()
                                                    ]
                            )
        ; 

    }

    /**
     * @Route("/user/user/delete/{id}", name="user.user.delete", methods={"DELETE"})
     * @param User $user
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(User $user, Request $request, ObjectManager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'. $user->getId(), $request->request->get('_token'))) 
        {

            $manager->remove($user);
            $manager->flush();

            $this->addFlash('success', "L'uilisateur a été supprimé avec succès.");

        }

        return $this->redirectToRoute('user.user.index');
    }

    /**
     * @Route("/user/dashbord", name="user.dashbord")
     * @param User $user
     * @return Response
     */
    public function dashbord(): Response
    {
     
        $user = $this->getUser();

        $profile = $user->getProfile();
        $profileCompletion = 0;

        if($profile)
        {

            $profileTab[0] = $profile->getSex();
            $profileTab[1] = $profile->getBirthday();
            $profileTab[2] = $profile->getPhoto();
            $profileTab[3] = $profile->getAddress();
            $profileTab[4] = $profile->getAboutMe();

            $numberItems = 0;
            
            foreach ($profileTab as $value) 
            {

                if($value)
                {

                    $numberItems++;

                }

            }

            $profileCompletion = ($numberItems / count($profileTab)) * 100;

        }
        
        return $this->render('user/dashbord.html.twig', [
                                                            'user' => $user,
                                                            'current_menu' => 'dashbord',
                                                            'profileCompletion' => number_format($profileCompletion, 0)
                                                        ]
                            )
        ; 

    }

    /** 
     * @Route("/user/geolocation/session", name="user.geolocation.session") 
     */ 
    public function ajaxAction(Request $request) 
    {
        if($request->isXmlHttpRequest())
        {
            $userLatitude = $request->request->get('userLatitude');
            $userLongitude = $request->request->get('userLongitude');
            $userCity = $request->request->get('userCity');
            $userAddress = $request->request->get('userAddress'); 

            $this->container->get('session')->set('userLatitude', $userLatitude);
            $this->container->get('session')->set('userLongitude', $userLongitude);
            $this->container->get('session')->set('userCity', $userCity);
            $this->container->get('session')->set('userAddress', $userAddress);
             
            $response = new JsonResponse();
            $response->setData(array('success'=> 'Session variables created')); 

            return $response;
        }
        else
        {

            $response = new JsonResponse();
            $response->setData(array('error'=> 'Not a xmlHttpRequest'));
            return $response;
         
        }

    }

}
