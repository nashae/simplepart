<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\BlogArticle;
use App\Entity\Image;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $faker->addProvider(new PicsumPhotosProvider($faker));

        //articles
        for($i = 1; $i <= 100; $i++){
            $article = new Article;
            $title = $faker->sentence(mt_rand(3, 9));
            $subtitle = $faker->text(mt_rand(50, 150));
            $coverImage = $faker->imageUrl(1000,350, true);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(mt_rand(10, 12))) . '</p>';
            $createdAt = $faker->dateTimeBetween('-10 days', 'now');
            $catArray = ['international', 'france', 'economie', 'culture'];
            $article->setTitle($title)
                    ->setSubTitle($subtitle)
                    ->setCoverImage($coverImage)
                    ->setContent($content)
                    ->setCreatedAt($createdAt)
                    ->setCategory(array_rand(array_flip($catArray)));
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
            $blogArticle->setTitle($faker->sentence(mt_rand(3, 9)))
                        ->setContent($blogcontent)
                        ->setCreatedAt($faker->dateTimeBetween('-10 days', 'now'));
            $manager->persist($blogArticle);
        }


        $manager->flush();
    }
}
