<?php

namespace Modules\Payment\Contracts;

use Modules\Payment\Entities\Payment;



interface GatewayContract
{
    public function request($amount, $description);

    public function verify(Payment $payment);

    public function redirect();

    public function getName();
}
