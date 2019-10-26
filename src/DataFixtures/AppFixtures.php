<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Img;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fk = Factory::create('fr_FR');
        
        // --> Fixtures for Users.
        for ($i = 0; $i < 40; $i++){
            $user = new Users();
            $user->setMail($fk->email())
                ->setName($fk->lastName())
                ->setPassword('$2y$12$LzcaZfmZEXg7015vrvFApu768G8n/wXq7Y.6vAs65VSdHEjlvvsa2')
                ->setSurname($fk->firstName())
                ->setRoles(["ROLE_MEMBER"])
                ->setCreatedAt(new DateTime())
                ->setLastLog(new DateTime())
                ;
            $manager->persist($user);
        }

        $manager->flush();

        for ($i = 0; $i < 10; $i++) {

            // --> Création des images
            for ($j = 0; $j < mt_rand(5, 10); $j++) {
                $img = new Img();
                $img->setCode(strval($fk->numberBetween(1000000, 9999999)))
                    ->setName($fk->word() . ".jpg")
                    ->setPath($fk->imageUrl(640, 480, 'nightlife'))
                    ->setUploadedAt(new DateTime())
                    ;
                $manager->persist($img);
            }

            // --> Fixture pour un article!
            $article = new Article();
            $article->setApiData($fk->url)
                ->setTitle($fk->realText(100))
                ->setText($fk->realText(1200))
                ->setFormat(array_rand(["news", "publicEvent", "privateEvent", "releases", "members"], 1))
                ->setUser($manager->find(Users::class, random_int(1, 3)))
                ->addImg($img)
                ->setApiData($fk->url())
                ->setCreatedAt(new DateTime())
                ->setDateEvent($fk->dateTimeBetween('now', '20 years'))
                ;
            $manager->persist($article);
        }
        $manager->flush();
        return $this->redirectToRoute("home_public");
    }
}