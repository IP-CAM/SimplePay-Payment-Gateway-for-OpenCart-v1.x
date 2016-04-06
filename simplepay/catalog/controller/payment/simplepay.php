<?php

class ControllerPaymentSimplePay extends Controller
{
    /**
     * Checkout page
     */
    public function index()
    {
        $this->language->load('payment/simplepay');

        $this->data['button_confirm'] = $this->language->get('button_confirm');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $this->data['email'] = $order_info['email'];
        $this->data['phone'] = $order_info['telephone'];
        $this->data['order_id'] = $this->session->data['order_id'];
        $this->data['description'] = $this->config->get('simplepay_description');
        $this->data['address'] = $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'];
        $this->data['postal_code'] = $order_info['payment_postcode'];
        $this->data['city'] = $order_info['payment_city'];
        $this->data['country'] = $order_info['payment_iso_code_2'];
        $this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $this->data['currency'] = $order_info['currency_code'];
        $this->data['image'] = $this->config->get('simplepay_image');

        if ($this->config->get('simplepay_test')) {
            $this->data['key'] = $this->config->get('simplepay_public_test_key');
        } else {
            $this->data['key'] = $this->config->get('simplepay_public_live_key');
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/simplepay.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/simplepay.tpl';
        } else {
            $this->template = 'default/template/payment/simplepay.tpl';
        }

        $this->render();
    }

    /**
     * Handle checkout token and verify simplepay transaction
     */
    public function send()
    {
        $this->load->model('checkout/order');

        $order_status_complete = 5;
        $order_status_failed = 10;

        if ($this->config->get('simplepay_test')) {
            $private_key = $this->config->get('simplepay_private_test_key');
        } else {
            $private_key = $this->config->get('simplepay_private_live_key');
        }

        // Verify SimplePay transaction
        $token = $this->request->post['token'];

        $data = array(
            'token' => $token
        );
        $data_string = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://checkout.simplepay.ng/v1/payments/verify/');
        curl_setopt($ch, CURLOPT_USERPWD, $private_key . ':');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));

        $curl_response = curl_exec($ch);
        $curl_response = preg_split("/\r\n\r\n/", $curl_response);
        $response_content = $curl_response[1];
        $json_response = json_decode(chop($response_content), true);

        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $json = array();

        $this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('config_order_status_id'));

        if ($response_code == '200' && $json_response['response_code'] == '20000') {
            $this->model_checkout_order->update($this->session->data['order_id'], $order_status_complete, 'Success', false);

            $json['success'] = $this->url->link('checkout/success');

        } else {
            $this->model_checkout_order->update($this->session->data['order_id'], $order_status_failed, 'Failed', false);

            $this->log->write('SimplePay Payment failed: ' . $response_code);
            $json['error'] = $response_code;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}