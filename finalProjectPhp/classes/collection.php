<?php

class collection

{
    public $items = array();
    
    public function add($primary_key, $item)

    {

        $this->items[$primary_key] = $item;
    }
    
    
}
