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
create view v_orders as
select o.id,
       o.user_id,
       o.payment_method_id,
       o.payment_method_name,
       ph.new_payment_status_id as payment_status_id,
       ph.new_payment_status_name as payment_status_name,
       o.payment_address_id,
       o.payment_address_name,
       o.shipping_status_id,
       o.shipping_status_name,
       o.shipping_method_id,
       o.shipping_method_name,
       o.shipping_address_id,
       o.shipping_address_name,
       o.notes,
       o.discount_code,
       o.total,
       o.created_at,
       o.updated_at
from orders o
    left join payment_history ph on ph.id = (select max(ph.id) from payment_history ph where ph.order_id = o.id);
PGSQL
);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop view if exists v_orders;');
    }
};
