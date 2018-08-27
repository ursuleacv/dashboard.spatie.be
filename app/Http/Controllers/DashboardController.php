<?php

namespace App\Http\Controllers;

use App\Services\InstagramHistory\InstagramHistory;
use Illuminate\Routing\Controller;
use App\Services\TweetHistory\TweetHistory;
use Spatie\Valuestore\Valuestore;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard')->with([
            'pusherKey' => config('broadcasting.connections.pusher.key'),

            'pusherCluster' => config('broadcasting.connections.pusher.options.cluster'),

            'initialTweets' => TweetHistory::all(),

            'initialInstagramPhotos' => InstagramHistory::all(),

            'initialSockCount' => Valuestore::make(storage_path('app/socks.json'))->get('amount', 0),

            'usingNodeServer' => usingNodeServer(),
        ]);
    }
}
