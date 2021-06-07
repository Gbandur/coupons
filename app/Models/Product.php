<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Log;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $manufacturer_id
 * @property int $base_category
 * @property int|null $color_id
 * @property array|null $additional_categories
 * @property float $base_price
 * @property float $old_price
 * @property float $min_price
 * @property float $finally_price
 * @property float $profit_price
 * @property int $price_markup
 * @property int $min_price_markup
 * @property float $pb_price
 * @property int $pb_categories_id
 * @property string|null $manufacturer_product_link
 * @property bool $show_on_main_page
 * @property bool $is_in_main_slider
 * @property bool $is_hidden
 * @property bool $is_hidden_from_mirrors
 * @property bool $is_hidden_from_scan
 * @property bool $is_price_fixed
 * @property bool $is_on_promotion
 * @property bool $is_has_from_oi
 * @property int $oi_product_id
 * @property bool $another_shop_price
 * @property float $another_shop_correction
 * @property int $total_quantity_in_warehouses
 * @property array|null $quantity_by_warehouses
 * @property int $max_payments
 * @property int $max_payments_without_vat
 * @property array|null $addition_products
 * @property int $status
 * @property string|null $updated_by
 * @property Carbon|null $price_updated_at
 * @property int|null $sort
 * @property array|null $grp_agg_ids
 * @property array|null $grp_agg_values
 * @property int $views_count
 * @property int $weight
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read MediaCollection|Media[] $media
 * @property-read int|null $media_count
 * @property-read ProductMeta|null $meta
 * @property-read Collection|ProductAvailabilityByWarehouse[] $product_availability_by_warehouses
 * @property-read int|null $product_availability_by_warehouses_count
 * @property-read Category|null $product_category
 * @property-read ProductColor|null $product_color
 * @property-read ProductDeliveryAndWarranty|null $product_delivery_and_warranty
 * @property-read Collection|ProductPropertyValue[] $product_property_values
 * @property-read int|null $product_property_values_count
 * @property-read ProductZapConfig|null $product_zap_config
 * @property-read Collection|SaleIcon[] $sale_icons
 * @property-read int|null $sale_icons_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereAdditionProducts($value)
 * @method static Builder|Product whereAdditionalCategories($value)
 * @method static Builder|Product whereAnotherShopCorrection($value)
 * @method static Builder|Product whereAnotherShopPrice($value)
 * @method static Builder|Product whereBaseCategory($value)
 * @method static Builder|Product whereBasePrice($value)
 * @method static Builder|Product whereColorId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereFinallyPrice($value)
 * @method static Builder|Product whereGrpAggIds($value)
 * @method static Builder|Product whereGrpAggValues($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsHasFromOi($value)
 * @method static Builder|Product whereIsHidden($value)
 * @method static Builder|Product whereIsHiddenFromMirrors($value)
 * @method static Builder|Product whereIsHiddenFromScan($value)
 * @method static Builder|Product whereIsInMainSlider($value)
 * @method static Builder|Product whereIsOnPromotion($value)
 * @method static Builder|Product whereIsPriceFixed($value)
 * @method static Builder|Product whereManufacturerId($value)
 * @method static Builder|Product whereManufacturerProductLink($value)
 * @method static Builder|Product whereMaxPayments($value)
 * @method static Builder|Product whereMaxPaymentsWithoutVat($value)
 * @method static Builder|Product whereMinPrice($value)
 * @method static Builder|Product whereMinPriceMarkup($value)
 * @method static Builder|Product whereOiProductId($value)
 * @method static Builder|Product whereOldPrice($value)
 * @method static Builder|Product wherePbCategoriesId($value)
 * @method static Builder|Product wherePbPrice($value)
 * @method static Builder|Product wherePriceMarkup($value)
 * @method static Builder|Product wherePriceUpdatedAt($value)
 * @method static Builder|Product whereProfitPrice($value)
 * @method static Builder|Product whereQuantityByWarehouses($value)
 * @method static Builder|Product whereShowOnMainPage($value)
 * @method static Builder|Product whereSort($value)
 * @method static Builder|Product whereStatus($value)
 * @method static Builder|Product whereTotalQuantityInWarehouses($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUpdatedBy($value)
 * @method static Builder|Product whereViewsCount($value)
 * @method static Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 * @mixin Eloquent
 */
class Product extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'products';

    protected $casts = [
        'manufacturer_id' => 'int',
        'base_category' => 'int',
        'color_id' => 'int',
        'additional_categories' => 'array',
        'base_price' => 'float',
        'old_price' => 'float',
        'min_price' => 'float',
        'finally_price' => 'float',
        'profit_price' => 'float',
        'price_markup' => 'int',
        'min_price_markup' => 'int',
        'pb_price' => 'float',
        'pb_categories_id' => 'int',
        'show_on_main_page' => 'boolean',
        'is_in_main_slider' => 'boolean',
        'is_hidden' => 'boolean',
        'is_hidden_from_mirrors' => 'boolean',
        'is_hidden_from_scan' => 'boolean',
        'is_price_fixed' => 'boolean',
        'is_on_promotion' => 'boolean',
        'is_has_from_oi' => 'boolean',
        'oi_product_id' => 'int',
        'another_shop_price' => 'boolean',
        'another_shop_correction' => 'float',
        'total_quantity_in_warehouses' => 'int',
        'quantity_by_warehouses' => 'array',
        'max_payments' => 'int',
        'max_payments_without_vat' => 'int',
        'addition_products' => 'array',
        'status' => 'int',
        'sort' => 'int',
        'grp_agg_ids' => 'array',
        'grp_agg_values' => 'array',
        'views_count' => 'int',
        'weight' => 'int'
    ];

    protected $dates = [
        'price_updated_at'
    ];

    protected $fillable = [
        'manufacturer_id',
        'base_category',
        'color_id',
        'additional_categories',
        'base_price',
        'old_price',
        'min_price',
        'finally_price',
        'profit_price',
        'price_markup',
        'min_price_markup',
        'pb_price',
        'pb_categories_id',
        'show_on_main_page',
        'is_in_main_slider',
        'is_hidden',
        'is_hidden_from_mirrors',
        'is_hidden_from_scan',
        'is_price_fixed',
        'is_on_promotion',
        'is_has_from_oi',
        'oi_product_id',
        'another_shop_price',
        'another_shop_correction',
        'total_quantity_in_warehouses',
        'quantity_by_warehouses',
        'max_payments',
        'max_payments_without_vat',
        'addition_products',
        'status',
        'updated_by',
        'price_updated_at',
        'sort',
        'grp_agg_ids',
        'grp_agg_values',
        'views_count',
        'weight'
    ];



    public function registerMediaConversions(Media $media = null): void
    {
        try {
            $this->addMediaConversion('icon')->fit(Manipulations::FIT_FILL, 80, 30)->background('FFFFFF')->nonQueued();
            $this->addMediaConversion('list')->fit(Manipulations::FIT_FILL, 52, 52)->background('FFFFFF')->nonQueued();
            $this->addMediaConversion('small')->fit(Manipulations::FIT_FILL, 275, 275)->background('FFFFFF')->nonQueued();
            $this->addMediaConversion('thumb')->fit(Manipulations::FIT_FILL, 470, 375)->background('FFFFFF')->nonQueued();
        } catch (InvalidManipulation $e) {
            Log::error('Cant create icon for category');
            Log::error($e->getMessage());
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->useFallbackUrl(config('app.url').'/storage/images/no_img.jpg')->useFallbackPath(public_path('/storage/images/no_img.jpg'));
    }
}
