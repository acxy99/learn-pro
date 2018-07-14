<?php

namespace App\Policies;

use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Bouncer;

class UserPolicy {
    use HandlesAuthorization;

    public function __construct() {
        //
    }

    public function view(User $user, User $model) {
        return $user->can('view-user');
    }

    public function create(User $user) {
        return $user->can('create-user');
    }

    public function update(User $user, User $model) {
        return $user->can('update-user');
    }

    public function delete(User $user, User $model) {
        return $user->can('delete-user');
    }
}
