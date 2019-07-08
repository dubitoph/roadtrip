<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Fuel;
use App\Entity\Mark;
use App\Entity\Sort;
use App\Entity\Photo;
use App\Entity\Price;
use App\Entity\Advert;
use App\Entity\Period;
use App\Entity\Season;
use App\Entity\Address;
use App\Entity\Vehicle;
use App\Entity\Duration;
use App\Entity\Equipment;
use App\Entity\Insurance;
use App\Entity\InsurancePrice;
use App\Entity\IncludedMileage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AdvertFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $sortRepository = $manager->getRepository( Sort :: class );
        $markRepository =  $manager->getRepository( Mark :: class );
        $fuelRepository =  $manager->getRepository( Fuel :: class );
        $equipmentRepository =  $manager->getRepository( Equipment :: class );
        $seasonRepository =  $manager->getRepository( Season :: class );
        $durationRepository =  $manager->getRepository( Duration :: class );

        for ($i = 0; $i < 100 ; $i++)
        {

           $advert =  new Advert();

           $advert
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setCreatedAt($faker->dateTimeAD($max = 'now'))
                ->setExpiresAt(new \DateTime($advert->getCreatedAt()->format('Y-m-d H:i:s') . " + 1 year"))
                ->setExtraKilometerCost(mt_rand (1, 10) / 10)
           ;

           $vehicle =  new Vehicle();
           $sort =  new Sort();
           $mark =  new Mark();
           $fuel =  new Fuel();

           $vehicle->setManufactureDate($faker->dateTimeAD($max = 'now'));

           $sort = $sortRepository->find($faker->numberBetween(1, 3));
           $vehicle->setSort($sort);

           $mark = $markRepository->find($faker->numberBetween(1, 4));
           $vehicle->setMark($mark);

           $fuel = $fuelRepository->find($faker->numberBetween(1, 4));
           $vehicle->setFuel($fuel);

           $vehicle->setBedsNumber(rand(1, 10));
           $vehicle->setSeatsNumber(rand(1, 10));
           $vehicle->setLength($faker->randomFloat($nbMaxDecimals = 1, $min = 3, $max = 7));
           $vehicle->setHeight($faker->randomFloat($nbMaxDecimals = 1, $min = 2, $max = 4));
           $vehicle->setWeight($faker->numberBetween(500, 4000));
           $vehicle->setPower($faker->numberBetween(100, 350));

           if ($i % 2 == 1)
           {

            $vehicle->setGearbox("Manuelle");

           }
           else
           {
               $vehicle->setGearbox("Automatique");

           }

           for ($a = 1; $a < $faker->numberBetween(1, 8); $a++) 
           {
                $equipment = $equipmentRepository->find($a);
                $vehicle->addEquipment($equipment);

           }

           $situation = new Address();
           $situation->setStreet($faker->streetName);
           $situation->setNumber($faker->buildingNumber);
           $situation->setZipCode($faker->postcode);
           $situation->setLatitude($faker->latitude);
           $situation->setLongitude($faker->longitude);

           if ($i % 2 == 1)
           {

                $situation->setState("State" . $i);

           }

           $situation->setCity($faker->city);
           $situation->setCountry($faker->country);

           $vehicle->setSituation($situation);

           $advert->setVehicle($vehicle);
/*
           for ($l = 0; $l < $faker->numberBetween(0, 10); $l++)
           {

               $photo = new Photo();
               $photo->setName('photo' . $i . $l . ".jpg");

               if ($l = 1) {

                    $photo->setMainPhoto(true);

               }

               $advert->addPhoto($photo);

           }
*/
           $seasons = array();

           for ($j = 0; $j < $faker->numberBetween(0, 10); $j++) {

               $period = new Period();
               $period->setStart($faker->dateTimeInInterval($startDate = 'now', $interval = '+ 1 year'));
               $period->setEnd(new \DateTime($period->getStart()->format('Y-m-d H:i:s') . " + 10 days"));

               $season = $seasonRepository->find($faker->numberBetween(1, 4));
               $period->setSeason($season);
               $period->setAdvert($advert);

               $advert->addPeriod($period);

               $seasons[] = $season;
           }

           $unique_seasons = array_unique($seasons);
           $durations = $durationRepository->findAll();

           foreach ($unique_seasons as $unique_season)
           {

                foreach ($durations as $duration)
                {

                    $price = new Price();
                    $price->setPrice($faker->numberBetween(250, 1000));
                    $price->setDuration($duration);
                    $price->setSeason($unique_season);
                    $price->setAdvert($advert);

                    $advert->addPrice($price);
                }

           }

           $insurance = new Insurance();
           $advert->setInsurance($insurance);

           if ($i % 2 == 1)
           {

                $insurance->setIncluded(true);

           }
           else
           {

                $insurance->setIncluded(false);

                foreach ($durations as $duration)
                {

                    $insurancePrice = new InsurancePrice();
                    $insurancePrice->setPrice($faker->numberBetween(50, 150));
                    $insurancePrice->setDuration($duration);
                    $insurancePrice->setInsurance($insurance);

                    $insurance->addInsurancePrice($insurancePrice);

                }

           }

           $insurance->setDeductible($faker->numberBetween(250, 2000));
           $insurance->setAdvert($advert);

           $advert->setInsurance($insurance);

            foreach ($durations as $duration)
            {

                $includedMileage = new IncludedMileage();
                $includedMileage->setMileage($faker->numberBetween(500, 3000));
                $includedMileage->setAdvert($advert);
                $includedMileage->setDuration($duration);

                $advert->addIncludedMileage($includedMileage);

            }

            if ($i % 2 == 1)
            {

                $advert->setIncludedCleaning(true);

            }
            else
            {

                $advert->setIncludedCleaning(false);
                $advert->setCleaningCost($faker->numberBetween(50, 150));

            }

            $manager->persist($advert);

        }

        $manager->flush();

    }

}
