<?php

namespace App\Policies;

use App\User;
use App\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy {
    use HandlesAuthorization;

    public function __construct() {
        //
    }

    public function view(User $user, Profile $profile) {
        return true;
    }

    public function create(User $user) {
        //
    }

    public function update(User $user, Profile $profile) {
        return $user->isAn('admin') || $user->id == $profile->user_id;
    }

    public function delete(User $user, Profile $profile) {
        //
    }
}
