<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new PaymentMethod());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'code' => 'card_online', 'name' => 'Credit Card (Online)' ],
            [ 'code' => 'bank_transfer', 'name' => 'Bank Transfer' ],
            [ 'code' => 'cash_on_delivery', 'name' => 'Cash on Delivery' ],
        ];
    }
}
