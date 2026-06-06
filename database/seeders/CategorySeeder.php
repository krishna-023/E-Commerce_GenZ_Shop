<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [
            CategoryFile::womenFashion(),
            CategoryFile::healthAndBeauty(),
            CategoryFile::mensFashion(),
            CategoryFile::watchesAndAccessories(),
            CategoryFile::autoMobile(),
            // CategoryFile::electronicDevices(),
            // CategoryFile::tvAndHomeAppliance(),
            // CategoryFile::electronicAccessories(),
            // CategoryFile::groceriesAndPets(),
            // CategoryFile::babyAndToys(),
            // CategoryFile::homeAndLifestyle(),
            // CategoryFile::sportsAndOutdoor(),
            // CategoryFile::motorAndDie(),

        ];

        foreach ($categories as $k0 => $parent) {

            $p = Category::query()->updateOrCreate(
                [
                    'Category_Name' => $parent['name'],
                ],
                [
                    'parent_id' => null,
                ]
            );

            if (isset($parent['children'])) {
                $this->seedChildren($parent['children'], $p->id);
            }
        }
    }

    private function seedChildren($children, $parent_id): void
    {
        foreach ($children as $key => $child) {
            $c = Category::query()->updateOrCreate(
                [
                    'Category_Name' => $child['name'],
                ],
                [
                    'parent_id' => $parent_id,
                ]
            );

            if (isset($child['children'])) {
                $this->seedChildren($child['children'], $c->id);
            }
        }
    }
}
