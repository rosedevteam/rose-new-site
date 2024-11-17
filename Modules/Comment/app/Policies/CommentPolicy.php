<?php

namespace Modules\Comment\Policies;

use Modules\Comment\Models\Comment;
use Modules\User\Models\User;

class CommentPolicy
{
    // all
    public function view(User $user, Comment $model): bool
    {
        return $user->id === $model->author_id || $user->hasPermissionTo('view-comments');
    }

    public function edit(User $user, Comment $model): bool
    {
        return $user->id === $model->author_id || $user->hasPermissionTo('edit-comments');
    }

    // admin-panel
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete-comments');
    }
}
