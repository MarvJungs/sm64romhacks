<?php

namespace Database\Seeders;

use App\Models\NavbarLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $navbar_links = [
            array('id' => '1','created_at' => now(),'updated_at' => now(),'label' => 'News','link' => '/news','external' => '0','disabled' => '0'),
            array('id' => '2','created_at' => now(),'updated_at' => now(),'label' => 'ROM Hacks','link' => '/hacks','external' => '0','disabled' => '0'),
            array('id' => '3','created_at' => now(),'updated_at' => now(),'label' => 'Megapack','link' => '/megapack','external' => '0','disabled' => '0'),
            array('id' => '4','created_at' => now(),'updated_at' => now(),'label' => 'FAQ','link' => '/faq','external' => '1','disabled' => '0'),
            array('id' => '5','created_at' => now(),'updated_at' => now(),'label' => 'Discord','link' => '/discord','external' => '1','disabled' => '0'),
            array('id' => '6','created_at' => now(),'updated_at' => now(),'label' => 'Streams','link' => '/streams','external' => '0','disabled' => '0'),
            array('id' => '7', 'created_at' => now(), 'updated_at' => now(), 'label' => 'Support', 'link' => '/support', 'external' => 1, 'disabled' => '0')
        ];

        foreach ($navbar_links as $navbar_link) {
            NavbarLink::insert($navbar_link);
        }
    }
}
