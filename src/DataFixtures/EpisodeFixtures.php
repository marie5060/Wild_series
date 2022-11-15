<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create();

        
        for ($p=1 ; $p <= 5 ; $p++){
            for ($i = 1 ; $i <=5; $i++) {
                for ($j=1; $j<= 10; $j++){
        
                    $episode = new Episode();
                    $episode->setNumber($j);
                    $episode->setTitle($faker->words(3, true));
                    $episode->setSynopsis($faker->paragraphs(2, true));
                    
                    $episode->setSeason($this->getReference('season_reference_' . $i . '-' . $p));

                    $manager-> persist($episode);
            
                    

                 $manager->flush();
                }
        }


    }

   
    }

    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class,
        ];
    }
}