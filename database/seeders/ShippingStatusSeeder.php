<?php

namespace Database\Seeders;

use App\Models\ShippingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new ShippingStatus());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'code' => 'pending', 'name' => 'Pending' ],
            [ 'code' => 'shipped', 'name' => 'Shipped' ],
            [ 'code' => 'delivered', 'name' => 'Delivered' ],
        ];
    }
}
