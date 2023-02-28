<?php

namespace App\Tests\Functional;

use App\Entity\Category;
use App\Entity\Meal;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryTest extends WebTestCase
{
    public function testIfCreateCategoryIsSuccessfull(): void
    {
        $client = static::createClient();

        $urlGenerator = $client->getContainer()->get('router');
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 1);
        $client->loginUser($user);

        $category = $entityManager->getRepository(Category::class)->findOneBy([
            'id' => 1
        ]);

        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('category.new')
        );

        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=category]')->form([
            'category[name]' => "La création est réussite",
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertRouteSame('app_category');
    }


    // public function testIfReadCategoryIsSuccesful(): void
    // {
    //     $client = static::createClient();

    //     $urlGenerator = $client->getContainer()->get('router');

    //     $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    //     $user = $entityManager->find(User::class, 1);

    //     $client->loginUser($user);

    //     $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_meal'));

    //     $this->assertResponseIsSuccessful();
    //     $this->assertRouteSame('app_meal');
    // }
    // public function testIfUpdateAnCategroyIsSuccessfull(): void
    // {
    //     $client = static::createClient();

    //     $urlGenerator = $client->getContainer()->get('router');
    //     $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    //     $user = $entityManager->find(User::class, 1);
    //     $client->loginUser($user);

    //     $category = $entityManager->getRepository(Category::class)->findOneBy([
    //         'id' => 1
    //     ]);

    //     $crawler = $client->request(
    //         Request::METHOD_GET,
    //         $urlGenerator->generate('category.edit', ['id' => $category->getId()])
    //     );

    //     $this->assertResponseIsSuccessful();

    //     $form = $crawler->filter('form[name=category]')->form([
    //         'category[name]' => "Le test est réussi",
    //     ]);

    //     $client->submit($form);

    //     $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    //     $client->followRedirect();
    //     $this->assertRouteSame('app_category');
    // }

    // public function testIfDeleteAnMealIsSuccessful(): void
    // {
    //     $client = static::createClient();

    //     $urlGenerator = $client->getContainer()->get('router');
    //     $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    //     $user = $entityManager->find(User::class, 1);

    //     $client->loginUser($user);

    //     $meal = $entityManager->getRepository(Meal::class)->findOneBy([
    //         'name' => 'name'
    //     ]);

    //     $crawler = $client->request(
    //         Request::METHOD_GET,
    //         $urlGenerator->generate('meal.delete', ['id' => $meal->getId()])
    //     );

    //     $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    //     $client->followRedirect();

    //     $this->assertRouteSame('app_meal');
    // }

}


