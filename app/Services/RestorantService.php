<?php

namespace App\Services;

use Carbon\Carbon;
use Spatie\OpeningHours\OpeningHours;

class RestorantService 
{

    public static function getOpeningTime($values)
    {
        if ($values) {
            $openingHours = OpeningHours::create([
                'monday'     => [$values->m_from . '-' . $values->m_to],
                'tuesday'    => [$values->t_from . '-' . $values->t_to],
                'wednesday'  => [$values->w_from . '-' . $values->w_to],
                'thursday'   => [$values->th_from . '-' . $values->th_to],
                'friday'     => [$values->f_from . '-' . $values->f_to],
                'saturday'   => [$values->s_from . '-' . $values->s_to],
                'sunday'     => [$values->su_from . '-' . $values->su_to],
            ]);
            $now = Carbon::now();
            $range = $openingHours->currentOpenRange($now);
            if ($range) {
                return "It's open since " . $range->start() . "\n" . "It will close at " . $range->end() . "\n";
            } else {
                return "It's closed since " . $openingHours->previousClose($now)->format('l H:i') . "\n" .
                "It will re-open at " . $openingHours->nextOpen($now)->format('l H:i') . "\n";
            }
        }
    }
}