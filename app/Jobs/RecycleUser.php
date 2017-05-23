<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RecycleUser implements ShouldQueue
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
        // Recycle this user.
        if ($user->status == -1) {
            // Force delete all topics, posts, comments and wiki of this user.
            $user->topics>each(function ($item) {
                $item->forceDelete();
            });
            $user->posts->each(function ($item) {
                $item->forceDelete();
            });
            $user->wikis>each(function ($item) {
                $item->forceDelete();
            });
            $user->comments>each(function ($item) {
                $item->forceDelete();
            });
            $user->history()->forceDelete();
        }
    }

    public function failed(Exception $e) {
        // Send failed notification to admin.
    }
}
