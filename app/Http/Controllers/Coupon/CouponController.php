<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCoupon;
use App\Http\Requests\StoreCoupon;
use App\Models\Coupon;
use App\Services\Coupons\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    private CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Coupon $coupon)
    {
        $coupons = $coupon->getAllCoupons();
        $usedCouponsCount = $coupon->getUsedCouponCount();

        return response(['coupons' => $coupons, 'usedCouponCount' => $usedCouponsCount]);
    }

    public function create()
    {
        //
    }

    public function store(StoreCoupon $request)
    {
        return $this->couponService->store($request->all());
    }

    public function apply(ApplyCoupon $request)
    {
        return $this->couponService->apply($request);
    }

}
