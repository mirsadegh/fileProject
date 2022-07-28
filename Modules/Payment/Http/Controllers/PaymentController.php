<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Gateways\Gateway;
use Modules\Payment\Repositories\PaymentRepo;
use Modules\Payment\Events\PaymentWasSuccessful;

class PaymentController extends Controller
{


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


}
