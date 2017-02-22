<?php

namespace App\Policies;

use App\Models\User;
use App\Models\File;

class FilePolicy extends Policy
{
    public function update(User $user, File $file)
    {
        return $file->user == $user->id or $user->type >= 3;
    }

    public function destroy(User $user, File $file)
    {
        return $user->type >= 3;
    }
}
