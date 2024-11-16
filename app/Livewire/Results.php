<?php

namespace App\Livewire;

use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Results extends Component
{
    use WithPagination;

    public Collection $pokemons;

    public function mount(): void
    {
        $this->pokemons = Pokemon::results(limit: true);
    }

    public function loadMore(): void
    {
        $this->pokemons = Pokemon::results(limit: false);
    }

    public function render()
    {
        return view('livewire.results');
    }
}
