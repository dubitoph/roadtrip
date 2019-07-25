<?php
namespace App\Controller\media;

use App\Entity\media\Photo;
use App\Entity\advert\Advert;
use App\Form\media\PhotosAdvertType;
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
     *  @Route("/advert/photos/management/{id}", name="advert.photos.management")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function photosForm(Advert $advert, Request $request, ObjectManager $manager) 
    {

        $photos = $advert->getPhotos();
        $numberOldPhotos = count($photos);

        $recordedPhotos = array();
        $recordedPhotosNames = array();
        $recordedPhotosIds = array();

        $editMode = false;

        if ($numberOldPhotos > 0) 
        {

            $editMode = true;
            
            $recordedPhotos = $advert->getPhotos();

            foreach ($recordedPhotos as $recordedPhoto) {
            
                $recordedPhotosNames[] = $recordedPhoto->getName();
                $recordedPhotosIds[] = $recordedPhoto->getId();
            }
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

                $error = new FormError("Au moins une photo doit être cochée comme étant à afficher dans la liste des annonces");
                $form->addError($error);

            }
            elseif ($checkedMain > 1) 
            {

                $error = new FormError("Il ne peut y avoir qu'une photo cochée comme étant à afficher dans la liste des annonces");
                $form->addError($error);

            }

            $manager->persist($advert);
            $manager->flush();   

            if ($editMode) 
            {

                $this->addFlash('success', 'Les photos ont été modifiées avec succès.');

            }
            else
            {

                $this->addFlash('success', 'Les photos ont été ajoutées à votre annonce avec succès.');

            }           

            return $this->redirectToRoute('advert.periods.management', array('id' => $advert->getId()));
        }

        return $this->render('advert/photos.html.twig', [
                                                            'form' => $form->createView(),
                                                            'recordedPhotos' => $recordedPhotos,
                                                            'recordedPhotosNames' => $recordedPhotosNames,
                                                            'recordedPhotosIds' => $recordedPhotosIds, 
                                                            'editMode' => $numberOldPhotos > 0
                                                        ]
                            )
        ;

    }
    
    /**
     * Deleting a photo
     * 
     * @Route("photo/delete/{id}", name="photo.delete")
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
    
    
    /**
      * Updating photo file
      *
      * @Route("photo/update/{id}", name="photo.update")
      *
      * @param Photo $photo
      * @param Request $request
      * @param ObjectManager $manager
      * @return Response
      */
    public function update(Photo $photo, Request $request, ObjectManager $manager): Response
    {
        
        return new JsonResponse([
                                 'message' => 'Fonctionnement correct',
                                 'photoId' => $photo->getId()
                                ]
                               )
        ;
    }    

}
