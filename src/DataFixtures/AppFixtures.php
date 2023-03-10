<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use App\Entity\Category;
use App\Entity\Meal;
use App\Entity\Notice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        // fr_FR is for create a faker form with french words
        $this->faker = Factory::create('fr_FR');
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {

        

        //For create a fake Category
        for($i=0; $i < 15; $i++) {
            $category = new Category();
            $category->setName($this->faker->name);

            $manager->persist($category);
        }
        //For create a fake Agency
        $agencies = [];
        for($i = 1; $i <= 15; $i++){
            $agency = new Agency();
            $agency->setName($this->faker->name)
                ->setAddress($this->faker->address)
                ->setCity($this->faker->city)
                ->setWebsite("https://gosselink.fr/");

            $agencies[] = $agency;

            $manager->persist($agency);
        }

        // Create the meals
        $meals = [];
        for($i = 0; $i < 25; $i++){
            $meal = new Meal();
            $meal->setName($this->faker->word)
                ->setDescription($this->faker->text)
                ->setPrice(8)
                ->setCalorie(1000)
                ->setIdAgency($agencies[mt_rand(0, count($agencies) -1)])
            ;
            $meals[] = $meal;

            $manager->persist($meal);
        }
        $users = [];
        // For create a fake User
        for($i = 0; $i < 30; $i++) {
            $user = new User();
            $user->setLastname($this->faker->lastName)
                ->setFirstname($this->faker->firstName)
                ->setEmail($this->faker->email)
                ->setCity($this->faker->city)
                ->setPhone($this->faker->phoneNumber)
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
            // $hasherPassword = $this->hasher->hashPassword(
            //     $user,
            //     'password'
            // );
            // $user->setPassword($hasherPassword);
            $users[] = $user;
            $manager->persist($user);
        }

        // For set the notices 
        foreach($meals as $meal){
            for($i = 0; $i < mt_rand(0,4); $i++){
                $notice = new Notice();
                $notice->setRating(mt_rand(1, 5))
                    ->setComment($this->faker->text)
                    ->setUser($users[mt_rand(0, count($users) -1)])
                    ->setMeal($meal)
                ;

                $manager->persist($notice);

            }
        }



        $manager->flush();
    }
}