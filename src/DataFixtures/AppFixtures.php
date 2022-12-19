<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use App\Entity\Category;
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
        for($i = 1; $i <= 15; $i++){
            $agency = new Agency();
            $agency->setName($this->faker->name)
                ->setAddress($this->faker->address)
                ->setCity($this->faker->city)
                ->setWebsite($this->faker->name());

            $manager->persist($agency);
        }

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

            $manager->persist($user);
        }


        $manager->flush();
    }
}
