<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $program = new Program();
        $program->setTitle('Groot');
        $program->setSynopsis('aventures de groot');
        $program->setCategory($this->getReference('category_Animation'));
        $manager->persist($program);
        $this->addReference('program_1', $program);

        $program2 = new Program();
        $program2->setTitle('Game of throne');
        $program2->setSynopsis('le trone de fer');
        $program2->setCategory($this->getReference('category_Action'));
        $manager->persist($program2);
        $this->addReference('program_2', $program2);

        $program3 = new Program();
        $program3->setTitle('Rings of Power');
        $program3->setSynopsis('les anneaux de pouvoirs');
        $program3->setCategory($this->getReference('category_Fantastique'));
        $manager->persist($program3);
        $this->addReference('program_3', $program3);

        $program4 = new Program();
        $program4->setTitle('Malcolm');
        $program4->setSynopsis('la famille malcom');
        $program4->setCategory($this->getReference('category_Aventure'));
        $manager->persist($program4);
        $this->addReference('program_4', $program4);

        $program5 = new Program();
        $program5->setTitle('Walking dead');
        $program5->setSynopsis('les morts vivants');
        $program5->setCategory($this->getReference('category_Horreur'));
        $manager->persist($program5);
        $this->addReference('program_5', $program5);

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          CategoryFixtures::class,
        ];
    }


}