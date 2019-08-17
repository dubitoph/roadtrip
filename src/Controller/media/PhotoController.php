<?php
namespace App\Controller\media;

use App\Entity\media\Photo;
use App\Entity\advert\Advert;
use App\Form\advert\PhotosAdvertType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PhotoController extends AbstractController 
{

    /**
     * Creating and updating advert photos
     *
     *  @Route("/media/advert_photos/create/{id}", name="media.advert_photos.create")
     * 
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function photosForm(Advert $advert, Request $request, ObjectManager $manager): Response 
    {

        $recordedPhotos = $advert->getPhotos();
        $numberRecordedPhotos = count($recordedPhotos);

        $editMode = false;
        $current_menu = 'add_advert';

        if ($numberRecordedPhotos > 0) 
        {

            $editMode = true;
            $current_menu = 'dashbord';

        }

        $form = $this->createForm(PhotosAdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $photos = $advert->getPhotos();
            $numberPhotos = $photos->count();
                
            $checkedMain = 0;

            if ($numberPhotos > 0) 
            {
            
                foreach ($photos as $photo) 
                {
                    
                    $photo->setAdvert($advert);
                    
                    if ($photo->getMainPhoto()) 
                    {

                        $checkedMain++;
                        
                    }
                }
                
            }

            if ($numberPhotos > 0 && $checkedMain == 0) 
            {

                $error = new FormError("At least one photo must be checked as the main: it will be displayed in the list of adverts.");
                $form->addError($error);

            }
            elseif ($checkedMain > 1) 
            {

                $error = new FormError("There can only be one photo checked as the main.");
                $form->addError($error);

            }

            $manager->persist($advert);
            $manager->flush();   

            if ($editMode) 
            {

                $this->addFlash('success', 'The photos have been successfully updated.');

            }
            else
            {

                $this->addFlash('success', 'Photos have successfully been added to your advert.');

            }           

            return $this->redirectToRoute('advert.periods.management', array('id' => $advert->getId()));
        }        

        return $this->render('advert/photosCreation.html.twig', [
                                                                    'form' => $form->createView(),
                                                                    'recordedPhotos' => $recordedPhotos, 
                                                                    'editMode' => $editMode,
                                                                    'current_menu' => $current_menu
                                                                ]
                            )
        ;

    }
    
    /**
     * Deleting a photo
     * 
     * @Route("media/photo/delete/{id}", name="media.photo.delete")
     *
     * @param Photo $photo
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Photo $photo, Request $request, ObjectManager $manager): Response 
    {

        $profile = $photo->getProfile();
        
        if($profile)
        {

            $profile->setPhoto(null);
            $manager->persist($profile);

        }

        $manager->remove($photo);
        $manager->flush();

        $this->addFlash('success', 'Your photo was successfully removed.');
        
        return new JsonResponse(['success' => 1]);

    }   

}
