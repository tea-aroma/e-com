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
        DB::statement(<<<PGSQL
create view v_products as
select p.id,
       p.category_id,
       c.name as category_name,
       p.brand_id,
       b.name as brand_name,
       p.name,
       p.slug,
       p.quantity,
       p.price,
       p.discount,
       p.sku,
       p.description,
       p.is_active,
       pd.id as product_description_id,
       pd.title,
       pd.meta_keywords,
       pd.description as product_description,
       pd.short_description,
       pd.image,
       pd.images,
       p.created_at,
       p.updated_at
from products p
         left join categories c on c.id = p.category_id
         left join brands b on b.id = p.brand_id
         left join product_descriptions pd on p.id = pd.product_id;
PGSQL
);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop view if exists v_products');
    }
};
