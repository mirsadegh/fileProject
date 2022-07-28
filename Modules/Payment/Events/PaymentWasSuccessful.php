<?php

namespace Modules\Payment\Events;

use Modules\Payment\Entities\Payment;
use Illuminate\Queue\SerializesModels;

class PaymentWasSuccessful
{
    use SerializesModels;

    public $payment;
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
