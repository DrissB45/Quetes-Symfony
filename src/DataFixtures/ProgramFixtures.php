<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryKey => $categoryTitle) {
            for ($i = 0; $i < 3; $i++) { // 3 programmes par catégories
                $program = new Program();
                $program->setTitle('Série stylée');
                $program->setSynopsis($faker->paragraphs(1, true));
                $category = $this->getReference('category_' . $categoryKey);
                $program->setCategory($category);
                $manager->persist($program);
                $this->addReference('category_' . $categoryKey  . '_program_' . $i, $program);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class
        ];
    }
}
