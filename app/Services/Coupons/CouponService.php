<?php

namespace App\Services\Coupons;

use App\Http\Requests\StoreCoupon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Request;

class CouponService
{
    public function store($data)
    {
        try {
            $coupon = Coupon::create($data);
            $coupon->products()->sync($data['product_ids']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        return response(['message' => 'coupon created successfully', 'coupon' => $coupon], 200);
    }

    public function edit($coupon, $data)
    {
        try {
            $coupon->update($data);
            $coupon->products()->sync($data['product_ids']);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        return response(['message' => 'coupon updated successfully', 'coupon' => $coupon], 200);
    }

    public function activate($coupon)
    {
        $coupon->update([
            'is_active' => true
        ]);

        return response(['message' => 'coupon activated successfully', 'coupon' => $coupon], 200);
    }


    public function deactivate($coupon)
    {
        $coupon->update([
            'is_active' => false
        ]);

        return response(['message' => 'coupon deactivated successfully', 'coupon' => $coupon], 200);
    }

    public function apply($data)
    {
        //total comes from checkout and will be implemented, now it is a test value
        $total = 100;
        $coupon = Coupon::where('coupon_code', $data['coupon_code'])->first();
        if (!$coupon && $coupon->usage_count >= $coupon->count) {
            return response(['message' => 'sorry coupon is invalid']);
        }
        //put coupon discount in session
        session()->put([
            'name' => $coupon->code,
            'discount' => $coupon->discount($total)
        ]);

        return response(['message' => 'coupon applied successfully', 'coupon' => ['code' => $coupon->code, 'discount' => $coupon->discount]], 200);

    }
}
