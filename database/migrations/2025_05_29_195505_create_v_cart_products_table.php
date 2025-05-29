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
create view v_cart_products as
select cp.id,
       cp.cart_id,
       cp.product_id,
       cp.quantity,
       p.category_id,
       c.name as category_name,
       p.brand_id,
       b.name as brand_name,
       p.name,
       p.slug,
       p.price,
       p.discount,
       p.sku,
       cp.created_at,
       cp.updated_at
from cart_products cp
         left join public.products p on p.id = cp.product_id
left join public.categories c on c.id = p.category_id
left join public.brands b on b.id = p.brand_id;
PGSQL
);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop view if exists v_cart_products');
    }
};
