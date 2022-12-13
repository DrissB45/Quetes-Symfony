<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public const ACTOR_NUMBER = 10;
    public const ACTORS_BY_SERIES = 3;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::ACTOR_NUMBER; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name());
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);

            for ($j = 0; $j < self::ACTORS_BY_SERIES; $j++) {
                $program = $this->getReference('category_' . $faker->numberBetween(0, 4)  . '_program_' . $faker->numberBetween(0, 2));
                $actor->addProgram($program);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class
        ];
    }
}
