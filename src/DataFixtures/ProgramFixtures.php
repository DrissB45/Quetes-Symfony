<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAM_NUMBER = 3;
    public const PROGRAMS_BY_ACTOR = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryKey => $categoryTitle) {
            for ($i = 0; $i < self::PROGRAM_NUMBER; $i++) {
                $program = new Program();
                $program->setTitle($faker->sentence(2, true));
                $program->setSynopsis($faker->paragraphs(1, true));
                $category = $this->getReference('category_' . $categoryKey);
                $program->setCategory($category);
                $this->addReference('category_' . $categoryKey  . '_program_' . $i, $program);

                for ($j = 0; $j < self::PROGRAMS_BY_ACTOR; $j++) {
                    $actor = $this->getReference('actor_' . $faker->numberBetween(0, 10));
                    $program->addActor($actor);
                }
                $manager->persist($program);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
            ActorFixtures::class
        ];
    }
}
