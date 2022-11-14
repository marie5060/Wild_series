<?php

namespace App\DataFixtures;

//référence à l'entité que tu vas manipuler
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public const CATEGORIES = [
        "Action",
        "Aventure",
        "Animation",
        "Fantastique"
    ];
    //la méthode load qui est appelée lors du chargement des fixtures
    public function load(ObjectManager $manager)
    {
        foreach(self::CATEGORIES as $key => $categoryName){
        //instanciation d'un nouvel objet Category
        $category = new Category();
        //la définition du nom de cette nouvelle catégorie
        $category->setName( $categoryName);
        //la persistance en base de données
        $manager->persist($category);
        //référence pour chaque catégorie
        $this->addReference('category_' . $categoryName, $category);
    }
        $manager->flush();
    }
}