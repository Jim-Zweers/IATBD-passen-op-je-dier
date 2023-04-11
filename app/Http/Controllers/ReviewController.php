<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request){
        Review::create($request->handleRequest());
        return to_route('requests.inbox')->with('message', 'Review verzonden!');
    }

}
