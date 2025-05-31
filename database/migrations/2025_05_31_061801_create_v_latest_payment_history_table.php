<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();

        DB::statement(<<<PGSQL
create view v_latest_payment_history as
select ph.id,
       ph.user_id,
       ph.order_id,
       ph.old_payment_status_id,
       ph.old_payment_status_name,
       ph.new_payment_status_id,
       ph.new_payment_status_name,
       ph.token,
       ph.created_at,
       ph.updated_at
from (select *,
             row_number() over (partition by order_id order by id desc) as rn
      from payment_history) ph
where rn = 1;
PGSQL
);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop view if exists v_latest_payment_history');
    }
};
