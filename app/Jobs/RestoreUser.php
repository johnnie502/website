<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LogoffUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(User $user)
    {
         // Restore this user.
        if ($user->status == -1) {
            // Restore all topics, posts, comments and wiki of this user.
            $user->topics->each(function ($item) {
                $item->restore();
            });
            $user->posts->each(function ($item) {
                $item->restore();
            });
            $user->wikis->each(function ($item) {
                $item->restore();
            });
            $user->comments->each(function ($item) {
                $item->restore();
            });
            $user->history()->restore();
            $user->status = 1;
            $user->save();
        }
    }

    public function failed(Exception $e) {
        // Send failed notification to admin.
    }
}
