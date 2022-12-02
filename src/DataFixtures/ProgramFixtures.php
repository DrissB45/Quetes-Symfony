<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const SERIES =
    [
        'Sons Of Anarchy' => 'Histoires de bikers',
        'Vikings' => 'Aventures de Vikings',
        'My Hero Academia' => 'École de jeunes héros',
        'Game Of Thrones' => 'Bataille pour le trône de fer',
        'The Walking Dead' => 'Épidémie de zombies',
    ];

    public function load(ObjectManager $manager): void
    {
        $j = 0;
        foreach (self::SERIES as $title => $synopsis) {
            for ($i = 0; $i < 1; $i++) {
                $program = new Program();
                $program->setTitle($title);
                $program->setSynopsis($synopsis);
                $category = $this->getReference('category_' . $i);
                $program->setCategory($category);
                $manager->persist($program);
                $this->addReference('category_' . $i . '_program_' . $j, $program);
            }
            $j++;
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
