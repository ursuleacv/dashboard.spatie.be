<?php

namespace App\Tiles\Twitter\Commands;

use TwitterStreamingApi;
use Illuminate\Console\Command;

class ListenForHashTagsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:listen-for-hash-tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for hashtags being used on Twitter';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        TwitterStreamingApi::publicStream()
            ->whenHears('#kangaroorewards', function (array $tweet) {
                dump("{$tweet['user']['screen_name']} tweeted {$tweet['text']}");
            })
            ->startListening();

        // User stream
//        TwitterStreamingApi::userStream()
//            ->onEvent(function(array $event) {
//                if ($event['event'] === 'favorite') {
//                    echo "Our tweet {$event['target_object']['text']} got favorited by {$event['source']['screen_name']}";
//                }
//            })
//            ->startListening();
    }
}
