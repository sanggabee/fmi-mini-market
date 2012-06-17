<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderState
 *
 * @property AStateMachine $machine
 * @property-read Order $order
 * @author nikolay
 */
class OrderState extends AState
{
    /**
     * Fetches the associated Order object(Machine's owner).
     * 
     * @return Order
     */
    public function getOrder()
    {
        return $this->getMachine()->getOwner();
    }
}
