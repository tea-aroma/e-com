<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;


if (Schema::hasTable('settings') && \App\Standards\Enums\SettingKey::CRON_INTERVAL->model())
{
    \Illuminate\Support\Facades\Schedule::command('app:expire-default-statuses')
        ->cron(str_replace('_', ' ', (\App\Standards\Enums\SettingKey::CRON_INTERVAL->data()->value)))
        ->onSuccess(function ()
        {
            \Illuminate\Support\Facades\Log::info('Successfully updated records.');
        })
        ->onFailure(function ()
        {
            \Illuminate\Support\Facades\Log::error('Failed to update records.');
        });
}
