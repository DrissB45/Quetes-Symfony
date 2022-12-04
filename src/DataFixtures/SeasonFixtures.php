<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categoryKey = 0;
        foreach (CategoryFixtures::CATEGORIES as $categoryKey => $categoryName) {
            for ($i = 0; $i < 3; $i++) { //1 boucle pour créer 5 séries d'un coup
                for ($j = 0; $j < 5; $j++) { // 5 saisons par série
                    $season = new Season();
                    $season->setNumber($j + 1);
                    $season->setYear(2015 + 1);
                    $season->setDescription('La saison est incroyable');
                    $program = $this->getReference('category_' . $categoryKey . '_program_' . $i);
                    $this->addReference('category_' . $categoryKey . '_program_' . $i . '_season_' . $j, $season);
                    $season->setProgram($program);
                    $manager->persist($season);
                }
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
