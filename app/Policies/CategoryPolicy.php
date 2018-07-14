<?php

namespace App\Policies;

use App\User;
use App\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy {
    use HandlesAuthorization;

    public function index(User $user) {
        return $user->isAn('admin');
    }

    public function show(User $user, Category $category) {
        return $user->isAn('admin');
    }

    public function create(User $user) {
        return $user->isAn('admin');
    }

    public function update(User $user, Category $category) {
        return $user->isAn('admin');
    }

    public function delete(User $user, Category $category) {
        return $user->isAn('admin');
    }
}
