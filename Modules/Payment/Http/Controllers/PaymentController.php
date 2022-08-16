<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Gateways\Gateway;
use Modules\Payment\Repositories\PaymentRepo;
use Modules\Payment\Events\PaymentWasSuccessful;

class PaymentController extends Controller
{


    public function index(PaymentRepo $paymentRepo, Request $request)
    {
        $this->authorize("manage", Payment::class);
        $payments = $paymentRepo
            ->searchEmail($request->email)
            ->searchAmount($request->amount)
            ->searchInvoiceId($request->invoice_id)
            ->searchAfterDate(($request->start_date))
            ->searchBeforeDate(( $request->end_date))
            ->paginate();
        $last30DaysTotal = $paymentRepo->getLastNDaysTotal(-30);
        $last30DaysBenefit = $paymentRepo->getLastNDaysSiteBenefit(-30);
        $last30DaysSellerShare = $paymentRepo->getLastNDaysSellerShare(-30);
        $totalSell = $paymentRepo->getLastNDaysTotal();
        $totalBenefit = $paymentRepo->getLastNDaysSiteBenefit();

        $dates = collect();
        foreach (range(-30, 0) as $i) {
            $dates->put(now()->addDays($i)->format("Y-m-d"), 0);
        }

        $summery =  $paymentRepo->getDailySummery($dates);
        return view("payment::index", compact(
            "payments",
            "last30DaysTotal",
            "last30DaysBenefit",
            "totalSell",
            "totalBenefit", "last30DaysSellerShare", "summery", "dates"));
    }

    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));

        if (!$payment) {
            return redirect("/")->with('swal-error',"تراکنش مورد نظر یاقت نشد!");
        }

        $result = $gateway->verify($payment);

        if (is_array($result)) {

            $paymentRepo->changeStatus($payment->id, Payment::STATUS_FAIL);
            return redirect()->to($payment->paymentable->path())->with('swal-error',  $result['message']);
            //todo
        } else {
            event(new PaymentWasSuccessful($payment));
            $paymentRepo->changeStatus($payment->id, Payment::STATUS_SUCCESS);
            return redirect()->to($payment->paymentable->path())->with('swal-success',"پرداخت با موفقیت انجام شد.");
        }


    }

    public function purchases()
    {
        $payments =  auth()->user()->payments()->with("paymentable")->paginate();

        return view("payment::purchases", compact("payments"));
    }



}
