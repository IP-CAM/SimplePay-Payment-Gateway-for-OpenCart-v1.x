<?php

class ModelPaymentSimplePay extends Model
{
    public function getMethod($address, $total)
    {
        $this->language->load('payment/simplepay');

        $method_data = array(
            'code' => 'simplepay',
            'title' => $this->language->get('text_title'),
            'terms' => '',
            'sort_order' => ''
        );

        return $method_data;
    }
}
