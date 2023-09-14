<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(StoreCardRequest $request) {
        $fields = $request->validated();


    }
}
