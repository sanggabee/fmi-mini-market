<?php

/**
 * Description of OrderStateFinihed
 *
 * @author nikolay
 */
class OrderStateFinihed extends OrderState {
    
    public function afterEnter(AState $from) {
        // TODO: Implement finished order processing
        
        parent::afterEnter($from);
    }
}
