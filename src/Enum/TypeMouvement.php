<?php

namespace App\Enum;

enum TypeMouvement: string
{
    case CAISSE_PRESENT = 'caisse_present';
    case CAISSE_ABSENT = 'caisse_absent';
    case AMENDE = 'amende';
    case LOCATION = 'location';
    case INTERET = 'interet';
    case COTISATION_CAISSE = 'cotisation_caisse';

    public function label(): string
    {
        return match ($this) {
            self::CAISSE_PRESENT => 'Caisse présent',
            self::CAISSE_ABSENT => 'Caisse absent',
            self::AMENDE => 'Amende',
            self::LOCATION => 'Location',
            self::INTERET => 'Intérêt',
            self::COTISATION_CAISSE => 'Cotisation de caisse',
        };
    }
}
