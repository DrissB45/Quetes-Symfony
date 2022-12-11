<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture
{
    public const ACTOR_NUMBER = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryKey => $categoryName) {
            for ($i = 0; $i < self::ACTOR_NUMBER; $i++) {
                $actor = new Actor();
                $actor->setName($faker->name());
                $manager->persist($actor);
                $this->addReference('actor_' . $i, $actor);

                $program = $this->getReference('category_' . $categoryKey  . '_program_' . $faker->numberBetween(0, 3));
                $actor->addProgram($program);
            }
        }
        $manager->flush();
    }
}
