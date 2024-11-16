<?php

use App\Livewire\Results;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Vote::class)->name('home');

Route::get('/results', Results::class)->name('results');
