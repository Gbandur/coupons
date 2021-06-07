<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $type
 * @property int $count
 * @property float $value
 * @property bool $is_global
 * @property float $minimal_price
 * @property int $category_id
 * @property Carbon $start_date
 * @property Carbon|null $end_date
 * @property-read Collection|Product[] $presents
 * @property-read int|null $presents_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static Builder|Coupon newModelQuery()
 * @method static Builder|Coupon newQuery()
 * @method static Builder|Coupon query()
 * @method static Builder|Coupon whereCategoryId($value)
 * @method static Builder|Coupon whereCode($value)
 * @method static Builder|Coupon whereCount($value)
 * @method static Builder|Coupon whereEndDate($value)
 * @method static Builder|Coupon whereId($value)
 * @method static Builder|Coupon whereIsGlobal($value)
 * @method static Builder|Coupon whereMinimalPrice($value)
 * @method static Builder|Coupon whereName($value)
 * @method static Builder|Coupon whereStartDate($value)
 * @method static Builder|Coupon whereType($value)
 * @method static Builder|Coupon whereValue($value)
 * @mixin Eloquent
 */
class Coupon extends Model
{
    protected $table = 'coupons';
    public $timestamps = false;

    protected $casts = [
        'type' => 'int',
        'count' => 'int',
        'value' => 'float',
        'is_global' => 'boolean',
        'minimal_price' => 'float',
        'category_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'code',
        'type',
        'count',
        'value',
        'is_global',
        'minimal_price',
        'category_id',
        'start_date',
        'end_date'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'coupon_items', 'coupon_id', 'product_id')
            ->withPivot(['is_present'])->wherePivot('is_present', false);
    }

    public function presents(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'coupon_items', 'coupon_id', 'product_id')
            ->withPivot(['is_present'])->wherePivot('is_present', true);
    }
}
