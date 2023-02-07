<?php

namespace App\Services;

use Carbon\Carbon;
use Spatie\OpeningHours\OpeningHours;

class groceryService 
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
            $open = false;
            if ($range) {
                $openingHours->isOpen();
                $openMsg = "Closing at " . $range->end() . "\n";
                return ['openMsg' => $openMsg, 'openStatus' => $openingHours->isOpen()];
            } else {
                $open = false;
                $openMsg = "Opens at  " . $openingHours->nextOpen($now)->format('l h:i A') . "\n";
                return ['openMsg' => $openMsg, 'openStatus' => $openingHours->isOpen()];
            }
        }
    }

    public static function verifyPlan($grocery)
    {
        $plan = $grocery->plan->first();
        if (!$plan) {
            return true;
        }
        return (int)$plan->items === $grocery->getCountsAttribute()['products'] || (int)$plan->items < $grocery->getCountsAttribute()['products'];
    }
}