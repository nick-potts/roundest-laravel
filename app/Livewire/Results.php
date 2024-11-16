<?php

namespace App\Livewire;

use App\Models\Pokemon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Results extends Component
{

    #[Computed]
    public function pokemons(): Collection
    {
        return Pokemon::query()
            ->withCount(['loss', 'win'])
            ->get();
//            ->each
//            ->append('win_percentage')
//            ->sortByDesc(['win_percentage', 'win_count']);
    }

    public function render()
    {
        return view('livewire.results');
    }
}
