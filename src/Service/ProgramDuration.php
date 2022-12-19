<?php

namespace App\Service;

use App\Entity\Episode;
use App\Entity\Program;
use App\DataFixtures\EpisodeFixtures;

class ProgramDuration
{
    public function calculate(Program $program)
    {
        $seasons = $program->getSeasons();

        $duration = 0;

        foreach ($seasons as $season) {
            $episodes = $season->getEpisodes();
            foreach ($episodes as $episode) {
                $duration += $episode->getDuration();
            }
        }
        $days = floor($duration / 1440);
        $hours = floor(($duration - $days * 1440) / 60);
        $minutes = $duration- ($days * 1440) - ($hours * 60);

        return $days . ' jours ' . $hours . ' heures ' . $minutes . ' minutes';
    }
}
