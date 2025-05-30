<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new ShippingMethod());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'code' => 'courier', 'name' => 'Courier Delivery' ],
            [ 'code' => 'pickup', 'name' => 'Pickup' ],
            [ 'code' => 'postal', 'name' => 'Postal Service' ],
        ];
    }
}
