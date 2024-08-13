<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    public function league2022()
    {
        $games = [
            'Star Road' => [
                '20 Star',
                '80 Star',
                '130 Star',
            ],
            'Super Mario 74' => [
                '10 Star',
                '50 Star',
                '110 Star',
                '151 Star',
            ],
            'Despair Mario`s Gambit 64' => [
                '0 Star',
                '53 Star',
                '120 Star',
            ],
            'Lug`s Delightful Dioramas' => [
                '51 Star',
                '74 Star',
            ],
            'To The Moon' => [
                '16 Star',
                '41 Star',
                '85 Star'
            ],
        ];

        return view('apps.league2022', [
            'games' => $games
        ]);
    }

    public function league2023()
    {
        $categories = [
            'GS1',
            'GS81',
            'GS131',
            'MNE70',
            'MNE125',
            'ZAR12',
            'ZAR96',
            'ZAR170'
        ];
        return view('apps.league2023', [
            'categories' => $categories
        ]);
    }
}
