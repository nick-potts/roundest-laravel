<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class PokemonOld extends Model
{
    use Sushi;
    public $timestamps = false;

    public function getRows(): array
    {
        $query = '
            query GetAllPokemon {
                pokemon_v2_pokemon(where: {id: {_lte: 1025}}) {
                    id
                    pokemon_v2_pokemonspecy {
                        name
                    }
                }
            }
        ';
        $response = \Http::post('https://beta.pokeapi.co/graphql/v1beta', [
            'query' => $query
        ]);

        $pokemon = $response->json('data.pokemon_v2_pokemon');

        return collect($pokemon)->map(function ($pokemon) {
            return [
                'id' => $pokemon['id'],
                'name' => $pokemon['pokemon_v2_pokemonspecy']['name'],
                'dex_number' => $pokemon['id'],
                'imageUrl' => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{$pokemon['id']}.png",
            ];
        })->all();
    }

    protected function sushiShouldCache(): bool
    {
        return true;
    }


}
