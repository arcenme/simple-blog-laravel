<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Blog $blog)
    {
        return auth('admin')->check() || $user->id == $blog->created_by;
    }
}
