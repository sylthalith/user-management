<?php

namespace App\Controllers\Admin;

use App\Repositories\UserRepository;

class DashboardController
{
    public function __construct(
        private UserRepository $users,
    ) {}

    public function index() {
        template('admin/dashboard', [
            'totalUsersCount' => $this->users->count(),
            'weeklyUsersCount' => $this->users->countLastDays(7),
            'blockedUsersCount' => $this->users->countBlocked(),
            'recentUsers' => $this->users->getRecent(5),
        ]);
    }
}