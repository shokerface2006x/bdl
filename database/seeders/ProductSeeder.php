<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        $items = array(
            array('title' => 'Футболка "HERE WE GO"', 'price' => 3000, 'description' => '100% хлопок, принт по мотивам дяди.'),
            array('title' => 'Футболка "GOLLANDEC"', 'price' => 3000, 'description' => '100% хлопок, принт по мотивам дяди'),
            array('title' => 'Футболка "BDL DRIVER"', 'price' => 3000, 'description' => '100% хлопок, принт по мотивам дяди'),
            array('title' => 'Лонгслив "RHYTM WOMAN"', 'price' => 4000, 'description' => '100% хлопок, принт по мотивам дяди'),
            array('title' => 'Шоппер "DRUMMER"', 'price' => 1200, 'description' => '100% хлопок, принт по мотивам дяди'),
            array('title' => 'Кепка "RHYTM SECTION"', 'price' => 1000, 'description' => '100% хлопок, принт по мотивам дяди')
        );

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}
