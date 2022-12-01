<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private const TITLES = ['Sons Of Anarchy', 'Vikings', 'My Hero Academia', 'Game Of Thrones', 'The Walking Dead'];
    private const SYNOPSIS =
    [
        'Histoires de bikers',
        'Aventures de Vikings',
        'École de jeunes héros',
        'Bataille pour le trône de fer',
        'Épidémie de zombies'
    ];

    public function load(ObjectManager $manager): void
    {
        $program1 = new Program();
        $program1->setTitle('Sons of Anarchy');
        $program1->setSynopsis('Histoires de bikers');
        $program1->setCategory($this->getReference('categorie_Action'));
        $manager->persist($program1);

        $program2 = new Program();
        $program2->setTitle('Vikings');
        $program2->setSynopsis('Aventures de Vikings');
        $program2->setCategory($this->getReference('categorie_Aventure'));
        $manager->persist($program2);

        $program3 = new Program();
        $program3->setTitle('My Hero Academia');
        $program3->setSynopsis('École de jeunes héros');
        $program3->setCategory($this->getReference('categorie_Animation'));
        $manager->persist($program3);

        $program4 = new Program();
        $program4->setTitle('Game Of Thrones');
        $program4->setSynopsis('Bataille pour le trône de fer');
        $program4->setCategory($this->getReference('categorie_Fantastique'));
        $manager->persist($program4);

        $program5 = new Program();
        $program5->setTitle('The Walking Dead');
        $program5->setSynopsis('Épidémie de zombies');
        $program5->setCategory($this->getReference('categorie_Horreur'));
        $manager->persist($program5);

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
