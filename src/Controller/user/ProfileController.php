<?php

namespace App\Controller\user;

use App\Entity\user\User;
use App\Entity\user\Profile;
use App\Form\user\ProfileType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{

    /**
     * @Route("/user/profile/update", name="user.profile.update")
     * 
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function update(Request $request, ObjectManager $manager): Response
    {

        $user = $this->getUser();
        $profile = $user->getProfile();

        if(! $profile)
        {

            $profile = new Profile();

            $profile->setUser($user);

        }

        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {   
            
            $photo = $profile->getPhoto();

            if ($photo) 
            {

                $photo->setProfile($profile);

            }
            
            $address = $profile->getAddress();
            
            if (! $address->getCity()) 
            {

                $profile->setAddress(null);

            }
            
            $manager->persist($profile);
            $manager->flush();    

            $this->addFlash('success', "Your profile was successfully updated");      

            return $this->redirectToRoute('user.profile.update');
        }
     
        return $this->render('user/profile/update.html.twig', array(
                                                                        'profile' => $profile,
                                                                        'bodyId' =>  'profileUpdate',
                                                                        'form' => $form->createView()
                                                                   )
                            )
        ;        
    }

    /**
     * @Route("/user/profile/show/{id}", name="user.profile.show")
     * 
     * @return Response
     */
    public function show(User $user): Response
    {
        
        $profile = $user->getProfile();
     
        return $this->render('user/profile/show.html.twig', array(
                                                                        'profile' => $profile,
                                                                        'bodyId' =>  'profileShow'
                                                                   )
                            )
        ;

    }

}