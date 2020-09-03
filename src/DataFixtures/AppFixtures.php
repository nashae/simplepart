<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Image;
use App\Entity\Article;
use App\Entity\BlogArticle;
use App\Entity\Users;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;   
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new PicsumPhotosProvider($faker));

        //users
        $users = [];
        /*$roles = [
            [],
            ['ROLE_AUTHOR']
        ];*/
        
        for ($i = 1; $i <= 20; $i++){
            $user = new Users();
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setEmail($faker->email)
                 ->setUserName($faker->firstName)
                 ->setPassword($password);
                 //->setRoles($faker->randomElement($roles))
            $manager->persist($user);
            $users[] = $user;     
        }
        
        //articles
        for($i = 1; $i <= 100; $i++){
            $article = new Article;
            $title = $faker->sentence(mt_rand(3, 9));
            $subtitle = $faker->text(mt_rand(50, 150));
            $coverImage = $faker->imageUrl(1000,350, true);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(mt_rand(10, 12))) . '</p>';
            $createdAt = $faker->dateTimeBetween('-10 days', 'now');
            $catArray = ['international', 'france', 'economie', 'culture'];
            $user = $users[mt_rand(count($users) - 5, count($users) - 1)];
            $article->setTitle($title)
                    ->setSubTitle($subtitle)
                    ->setCoverImage($coverImage)
                    ->setContent($content)
                    ->setCreatedAt($createdAt)
                    ->setCategory(array_rand(array_flip($catArray)))
                    ->setAuthor($user);
            $manager->persist($article);
            //images
            for($j = 1; $j <= mt_rand(2, 5); $j++){
                $image = new Image();
                $image->setUrl($faker->imageUrl(640,480, true))
                      ->setCaption($faker->sentence(mt_rand(5, 10)))
                      ->setArticle($article);
                $manager->persist($image);
            }

        }

        //blog
        for($i = 1; $i <= 50 ; $i++){
            $blogArticle = new BlogArticle();
            $createdAt = $faker->dateTimeBetween('-10 days', 'now');
            $blogcontent = '<p>' . join('</p><p>', $faker->paragraphs(mt_rand(5, 8))) . '</p>';
            $user = $users[mt_rand(count($users) - 20, count($users) - 6)];
            
            $blogArticle->setTitle($faker->sentence(mt_rand(3, 9)))
                        ->setContent($blogcontent)
                        ->setCreatedAt($faker->dateTimeBetween('-10 days', 'now'))
                        ->setAuthor($user);
            $manager->persist($blogArticle);

        }


        $manager->flush();
    }
}
