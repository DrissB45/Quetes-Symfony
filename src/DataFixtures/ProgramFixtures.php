<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (CategoryFixtures::CATEGORIES as $categoryKey => $categoryTitle) {
            for ($i = 0; $i < 3; $i++) {
                $program = new Program();
                $program->setTitle('Série stylée');
                $program->setSynopsis('Synopsis de la série');
                $category = $this->getReference('category_' . $categoryKey);
                $program->setCategory($category);
                $manager->persist($program);
                $this->addReference('category_' . $categoryKey . '_program_' . $i, $program);
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
