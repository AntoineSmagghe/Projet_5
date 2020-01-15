<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Img;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $formats = [
        'publicEvent'=> 'Public event',
        'privateEvent' => 'Private event', 
        'news' => 'News', 
        'releases' => 'Release', 
        'members' => 'Membres' 
    ];

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
        
        for ($i = 0; $i < 10; $i++) {
            // --> Création des images
            for ($j = 0; $j < mt_rand(5, 10); $j++) {
                $img = new Img();
                $img->setName($fk->word() . ".jpg")
                    ->setUploadedAt(new DateTime())
                    ;
                $manager->persist($img);
            }
            
            // --> Fixture pour un article!
            $article = new Article();
            $article->setApiData(new ArrayCollection())
                ->setTitle($fk->realText(100))
                ->setText($fk->realText(6300))
                ->setFormat(array_rand($this->formats, 1))
                ->setUser($user)
                ->addImg($img)
                ->setApiData($fk->url())
                ->setCreatedAt(new DateTime())
                ->setDateEvent($fk->dateTimeBetween('now', '20 years'))
                ;
            $manager->persist($article);
        }
        $manager->flush(); 
    }
}