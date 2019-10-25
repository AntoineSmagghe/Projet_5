<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Img;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /*
    public function load(ObjectManager $manager, UsersRepository $users)
    {
        
        // --> Faire une fixture des images avant! 
        $fk = Factory::create('fr_FR');
        
        for ($i = 0; i < 100; $i++){
            $img = new Img();


        }
        




        $fk = Factory::create('fr_FR');

        for ($i = 0; $i > 10; $i++) {
            $article = new Article();

            $user = $users->find(random_int(1,3));

            $article->setApiData($fk->url)
                    ->setFormat(array_rand(["News", "publicEvent", "privateEvent", "releases", "members"], 1))
                    ->setUser($user)
                    ->
            ;
            $manager->persist($article);
        }
        
        $manager->flush();
        
    }
    */
}