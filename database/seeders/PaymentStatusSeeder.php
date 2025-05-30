<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new PaymentStatus());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'code' => 'pending', 'name' => 'Pending' ],
            [ 'code' => 'paid', 'name' => 'Paid' ],
            [ 'code' => 'canceled', 'name' => 'Canceled' ],
        ];
    }
}
