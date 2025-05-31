<?php

namespace App\Console\Commands;

use App\Standards\Payment\PaymentHistoryExpired;
use Illuminate\Console\Command;

class ExpireDefaultStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-default-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire payments with default status';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        (new PaymentHistoryExpired())->execute();

        return self::SUCCESS;
    }
}
