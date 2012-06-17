<?php

/**
 * Description of OrderStateNew
 *
 * @author nikolay
 */
class OrderStateNew extends OrderState {
    public function finish() {
        $this->order->state = Order::STATE_FINISHED;
        if($this->order->save(false, array('state', 'update_time',)))
            $this->machine->transition(Order::STATE_FINISHED);
    }
}
