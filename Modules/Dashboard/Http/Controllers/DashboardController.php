<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Payment\Repositories\PaymentRepo;

class DashboardController extends Controller
{
    public function index(PaymentRepo $paymentRepo)
    {
        $totalSales = $paymentRepo->getUserTotalSuccessAmount(auth()->id());
        $totalBenefit = $paymentRepo->getUserTotalBenefit(auth()->id());
        $totalSiteShare = $paymentRepo->getUserTotalSiteShare(auth()->id());
        $todayBenefit = $paymentRepo->getUserTotalBenefitByDay(auth()->id(), now());
        $last30DaysBenefit = $paymentRepo->getUserTotalBenefitByPeriod(auth()->id(), now(), now()->addDays(-30));
        $todaySuccessPaymentsTotal = $paymentRepo->getUserTotalSellByDay(auth()->id(), now());
        $todaySuccessPaymentsCount = $paymentRepo->getUserSellCountByDay(auth()->id(), now());

        $payments = $paymentRepo->paymentsBySellerId(auth()->id())->paginate();

        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();

        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }
        $summery =  $paymentRepo->getDailySummery($dates, auth()->id());

        return view('dashboard::index', compact(
                "totalSales",
                "totalBenefit",
                "totalSiteShare",
                "todayBenefit",
                "last30DaysBenefit",
                "todaySuccessPaymentsTotal",
                "todaySuccessPaymentsCount",
                "last30DaysTotal",
                "last30DaysSellerShare",
                "totalSell",
                "payments",
                "dates",
                "summery"
            )
        );
    }


}
