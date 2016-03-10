<?php

class ControllerPaymentSimplePay extends Controller
{
    private $error = array();

    /**
     * Admin page
     */
    public function index()
    {
        $this->load->language('payment/simplepay');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('simplepay', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_edit'] = $this->language->get('text_edit');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');

        $this->data['entry_test'] = $this->language->get('entry_test');
        $this->data['entry_private_live_key'] = $this->language->get('entry_private_live_key');
        $this->data['entry_public_live_key'] = $this->language->get('entry_public_live_key');
        $this->data['entry_private_test_key'] = $this->language->get('entry_private_test_key');
        $this->data['entry_public_test_key'] = $this->language->get('entry_public_test_key');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_image'] = $this->language->get('entry_image');

        $this->data['entry_status'] = $this->language->get('entry_status');

        $this->data['help_test'] = $this->language->get('help_test');
        $this->data['help_description'] = $this->language->get('help_description');
        $this->data['help_image'] = $this->language->get('help_image');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['private_live_key'])) {
            $this->data['error_private_live_key'] = $this->error['private_live_key'];
        } else {
            $this->data['error_private_live_key'] = '';
        }

        if (isset($this->error['public_live_key'])) {
            $this->data['error_public_live_key'] = $this->error['public_live_key'];
        } else {
            $this->data['error_public_live_key'] = '';
        }

        if (isset($this->error['private_test_key'])) {
            $this->data['error_private_test_key'] = $this->error['private_test_key'];
        } else {
            $this->data['error_private_test_key'] = '';
        }

        if (isset($this->error['public_test_key'])) {
            $this->data['error_public_test_key'] = $this->error['public_test_key'];
        } else {
            $this->data['error_public_test_key'] = '';
        }

        if (isset($this->error['description'])) {
            $this->data['error_description'] = $this->error['description'];
        } else {
            $this->data['error_description'] = '';
        }

        if (isset($this->error['image'])) {
            $this->data['error_image'] = $this->error['image'];
        } else {
            $this->data['error_image'] = '';
        }

        // Breadcrumbs
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/simplepay', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        // Admin buttons
        $this->data['action'] = $this->url->link('payment/simplepay', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        // Admin form submit
        if (isset($this->request->post['simplepay_test'])) {
            $this->data['simplepay_test'] = $this->request->post['simplepay_test'];
        } else {
            $this->data['simplepay_test'] = $this->config->get('simplepay_test');
        }

        if (isset($this->request->post['simplepay_private_live_key'])) {
            $this->data['simplepay_private_live_key'] = $this->request->post['simplepay_private_live_key'];
        } else {
            $this->data['simplepay_private_live_key'] = $this->config->get('simplepay_private_live_key');
        }

        if (isset($this->request->post['simplepay_public_live_key'])) {
            $this->data['simplepay_public_live_key'] = $this->request->post['simplepay_public_live_key'];
        } else {
            $this->data['simplepay_public_live_key'] = $this->config->get('simplepay_public_live_key');
        }

        if (isset($this->request->post['simplepay_private_test_key'])) {
            $this->data['simplepay_private_test_key'] = $this->request->post['simplepay_private_test_key'];
        } else {
            $this->data['simplepay_private_test_key'] = $this->config->get('simplepay_private_test_key');
        }

        if (isset($this->request->post['simplepay_public_test_key'])) {
            $this->data['simplepay_public_test_key'] = $this->request->post['simplepay_public_test_key'];
        } else {
            $this->data['simplepay_public_test_key'] = $this->config->get('simplepay_public_test_key');
        }

        if (isset($this->request->post['simplepay_description'])) {
            $this->data['simplepay_description'] = $this->request->post['simplepay_description'];
        } else {
            $this->data['simplepay_description'] = $this->config->get('simplepay_description');
        }

        if (isset($this->request->post['simplepay_image'])) {
            $this->data['simplepay_image'] = $this->request->post['simplepay_image'];
        } else {
            $this->data['simplepay_image'] = $this->config->get('simplepay_image');
        }

        if (isset($this->request->post['simplepay_status'])) {
            $this->data['simplepay_status'] = $this->request->post['simplepay_status'];
        } else {
            $this->data['simplepay_status'] = $this->config->get('simplepay_status');
        }

        $this->template = 'payment/simplepay.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    /**
     * Validate admin form
     */
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/simplepay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['simplepay_private_test_key']) {
            $this->error['private_test_key'] = $this->language->get('error_private_test_key');
        }

        if (!$this->request->post['simplepay_public_test_key']) {
            $this->error['public_test_key'] = $this->language->get('error_public_test_key');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
