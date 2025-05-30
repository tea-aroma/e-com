<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cache::flush();

        $this->call(CategorySeeder::class);

        $this->call(BrandSeeder::class);

        $this->call(PaymentMethodSeeder::class);

        $this->call(PaymentStatusSeeder::class);

        $this->call(ShippingMethodSeeder::class);

        $this->call(ShippingStatusSeeder::class);

        $this->call(SettingSeeder::class);

        $this->call(UserSeeder::class);
    }

    /**
     * Creates records by the specified arguments.
     *
     * @param array $records
     * @param Model $model
     *
     * @return void
     */
    public static function createRecords(array $records, Model $model): void
    {
        foreach ($records as $record)
        {
            $model->newQuery()->create($record);
        }
    }
}
