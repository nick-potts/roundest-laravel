<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Number;
use Webmozart\Assert\Assert;

class Pokemon extends Model
{
    public $timestamps = false;

    // from the votes table, generate a winner count and loser count attribute

    public function win()
    {
        return $this->hasMany(Vote::class, 'winner_id');
    }

    public function loss()
    {
        return $this->hasMany(Vote::class, 'loser_id');
    }

    public function winPercentage(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->win_count + $this->loss_count === 0) {
                return "0.0%";
            }
            return Number::percentage($this->win_count / ($this->win_count + $this->loss_count), 1);
        });
    }


    public static function fetch(int $count): array
    {
        return static::inRandomOrder()
            ->limit($count)
            ->get()
            ->map(fn(Pokemon $pokemon) => (object)$pokemon->toArray())
            ->all();
    }
}
