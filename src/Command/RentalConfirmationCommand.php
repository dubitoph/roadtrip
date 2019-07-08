<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class RentalConfirmationCommand extends ContainerAwareCommand 
{

    protected function configure () 
    {
            
        $this->setName('app:rental-confirmation');
        $this->setDescription("Rental automatically validation");
        $this->setHelp("Finding all ratings with rentalApproved on null and with created_at prior to a period fixed in parameters");

    }

    public function execute (InputInterface $input, OutputInterface $output) 
    {
            
        $manager = $this->getContainer()->get('doctrine')->getEntityManager();
        $ratingRepository = $manager->getRepository("App:advert\Rating");

        $ratingRepository->toConfirmRental($this->getContainer()->getParameter('rental_automatically_confirmation'));

    }

}