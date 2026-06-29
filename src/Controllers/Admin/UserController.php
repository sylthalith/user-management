<?php

namespace App\Controllers\Admin;

use App\Pagination\Paginator;
use App\Repositories\UserRepository;
use App\Request;

class UserController
{
    public function __construct(
        private Request $request,
        private UserRepository $users,
    ) {}

    public function index() {
        $page = $this->request->getQueryInt('page', 0);

        $paginator = new Paginator($this->users, 3, $page, 3);

        template('admin/users', ['paginator' => $paginator]);
    }

    public function show($id) {
        dd($id);
    }
}