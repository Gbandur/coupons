<?php

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('manufacturer_id');
            $table->smallInteger('base_category');
            $table->integer('color_id')->nullable();
            $table->jsonb('additional_categories')->nullable();
            $table->decimal('base_price')->default(1);
            $table->decimal('old_price')->default(0);
            $table->decimal('min_price')->default(0);
            $table->decimal('finally_price')->default(1);
            $table->decimal('profit_price')->default(0);
            $table->smallInteger('price_markup')->default(0);
            $table->smallInteger('min_price_markup')->default(0);
            $table->decimal('pb_price')->default(0);
            $table->integer('pb_categories_id')->default(0);
            $table->string('manufacturer_product_link')->nullable();
            $table->boolean('show_on_main_page')->default(false);
            $table->boolean('is_in_main_slider')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_hidden_from_mirrors')->default(false);
            $table->boolean('is_hidden_from_scan')->default(false);
            $table->boolean('is_price_fixed')->default(false);
            $table->boolean('is_on_promotion')->default(false);
            $table->boolean('is_has_from_oi')->default(false);
            $table->integer('oi_product_id')->default(false);
            $table->boolean('another_shop_price')->default(false);
            $table->decimal('another_shop_correction')->default(0);
            $table->integer('total_quantity_in_warehouses')->default(0);
            $table->jsonb('quantity_by_warehouses')->nullable();
            $table->smallInteger('max_payments')->default(1);
            $table->smallInteger('max_payments_without_vat')->default(1);
            $table->jsonb('addition_products')->nullable();
            $table->smallInteger('status')->default(ProductStatus::InStock);
            $table->string('updated_by')->nullable();
            $table->timestamp('price_updated_at')->nullable();
            $table->smallInteger('sort')->nullable();
            $table->jsonb('grp_agg_ids')->nullable();
            $table->jsonb('grp_agg_values')->nullable();
            $table->bigInteger('views_count')->default(0);
            $table->bigInteger('weight')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
