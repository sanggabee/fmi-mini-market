<?php

/**
 * Manages functionality of an order in new state.
 *
 * @author nikolay
 */
class OrderStateNew extends OrderState {
    /**
     * Draws all of the OrderItem's quantities from product's current_quantity
     * and places the order in finished state.
     *
     * @return boolean True on success.
     */
    public function finish() {
        $transaction = $this->order->getDbConnection()->beginTransaction();
        try {
            foreach($this->order->orderItems as $orderItem) /* @var $orderItem OrderItem */
                if(!$orderItem->changeProductQuantity())
                    throw new Exception('Can not change product quantity!');
        
            $this->order->state = Order::STATE_FINISHED;
            if(!$this->order->save(false, array('state', 'update_time',)))
                throw new Exception('Can not save order state!');

            if(!$this->machine->transition(Order::STATE_FINISHED))
                throw new Exception('Can not transition to finished state!');
                
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->order->state = Order::STATE_NEW;
            $this->order->addError('state', $e->getMessage());
            return false;
        }
        return true;
    }
}
