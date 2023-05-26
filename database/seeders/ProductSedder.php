<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productNames = [
            'iPhone',
            'Samsung Galaxy',
            'Sony PlayStation',
            'Nike Air Max',
            'Coca-Cola',
            'Toyota Corolla',
            'Dell XPS',
            'Canon EOS',
            'Adidas Superstar',
            'Amazon Echo',
        ];

        foreach ($productNames as $name) {
            Product::factory()->create(['name' => $name]);
        }
    }
}
