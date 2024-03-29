<?php

namespace Modules\Payment\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddSellersShareToHisAccount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->payment->seller){
            $event->payment->seller->balance += $event->payment->seller_share;
            $event->payment->seller->save();
        }
    }
}
