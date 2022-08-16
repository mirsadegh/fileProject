<?php

namespace Modules\Payment\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Payment\Entities\Payment;

class PaymentWasSuccessful
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
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
