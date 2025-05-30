<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DatabaseSeeder::createRecords($this->getRecords(), new Setting());
    }

    /**
     * @return array[]
     */
    protected function getRecords(): array
    {
        return [
            [ 'key' => 'default_payment_status_id', 'value' => '1' ],
            [ 'key' => 'expired_payment_status_id', 'value' => '3' ],
            [ 'key' => 'expired_payment_status_time', 'value' => '120' ],
            [ 'key' => 'default_shipping_status_id', 'value' => '1' ],
        ];
    }
}
