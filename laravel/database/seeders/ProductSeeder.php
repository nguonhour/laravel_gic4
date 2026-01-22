<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/products.json');
        if (! file_exists($path)) {
            echo "products.json not found at: {$path}\n";
            return;
        }

        $json = file_get_contents($path);
        $items = json_decode($json, true);
        if (! is_array($items)) {
            echo "products.json decode failed\n";
            return;
        }

        foreach ($items as $item) {
            // Use updateOrCreate to be idempotent
            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'description' => $item['description'] ?? null,
                    // DB column is `pricing` in migrations — map incoming `price` to `pricing`
                    'pricing' => $item['price'] ?? 0,
                    'category_id' => $item['category_id'] ?? null,
                ]
            );
            echo "Imported: {$item['name']}\n";
        }
    }
}
