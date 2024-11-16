<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Models\Pokemon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Webmozart\Assert\Assert;

#[AllowDynamicProperties]
class Vote extends Component
{
    public array $pokemons;
    public array $nextTen;

    public function mount()
    {
        $this->pokemons = Pokemon::fetch(2);
        $this->nextTen = Pokemon::fetch(10);
    }

    public function vote(int $index): \Illuminate\Http\RedirectResponse
    {
        Assert::lessThan($index, 2);
        $winner = $this->pokemons[$index];
        $loser = $this->pokemons[1 - $index % 2];

        \App\Models\Vote::create([
            'winner_id' => $winner->id,
            'loser_id' => $loser->id,
        ]);

        $this->pokemons = \Arr::take($this->nextTen, 2);
        $this->nextTen = [
            ...\Arr::except($this->nextTen, [0, 1]),
            ...Pokemon::fetch(2)
        ];

        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.vote');
    }
}
