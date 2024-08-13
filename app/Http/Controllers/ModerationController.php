<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function index()
    {
        $actions = [
            ['name' => 'View Comments', 'link' => 'moderation/comments', 'role_id' => 2],
            ['name' => 'Verify Hacks', 'link' => 'moderation/hacks', 'role_id' => 2],
            ['name' => 'Manage Users', 'link' => 'moderation/users', 'role_id' => 2],
            ['name' => 'Manage Events', 'link' => 'moderation/events', 'role_id' => 3],
            ['name' => 'Manage Hacks', 'link' => 'moderation/hacks/manage', 'role_id' => 2]
        ];
        return view('moderation.index', [
            'actions' => $actions
        ]);
    }
}
