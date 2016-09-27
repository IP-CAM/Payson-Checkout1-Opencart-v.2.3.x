<?php

class ControllerExtensionPaymentPaysondirect extends Controller {

    private $error = array();
    //private $data = array();

    public function index() {
        //Load the language file for this module
        $this->load->language('extension/payment/paysondirect');

        //Set the title from the language file $_['heading_title'] string
        $this->document->setTitle($this->language->get('heading_title'));

        //Load the settings model. You can also add any other models you want to load here.
        $this->load->model('setting/setting');
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).		
        if (($this->request->server['REQUEST_METHOD'] == 'POST')&& $this->validate()) {
            $this->model_setting_setting->editSetting('paysondirect', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_modul_name'] = $this->language->get('text_modul_name');
        $data['text_modul_version'] = $this->language->get('text_modul_version');
        //$data['modul_version'] = $this->language->get('text_modul_version');
        
        $data['text_edit']       = $this->language->get('text_edit');
        $data['user_name'] = $this->language->get('user_name');
        $data['agent_id'] = $this->language->get('agent_id');
        $data['md5'] = $this->language->get('md5');
        $data['paysondirect_method_card_bank_info'] = $this->language->get('payment_method_card_bank_info');

        $data['secure_word'] = $this->language->get('secure_word');
        $data['entry_logg'] = $this->language->get('entry_logg');


        $data['payment_method_card'] = $this->language->get('payment_method_card');
        $data['payment_method_bank'] = $this->language->get('payment_method_bank');
        $data['payment_method_inv'] = $this->language->get('payment_method_inv');
        $data['payment_method_sms'] = $this->language->get('payment_method_sms');
        $data['payment_method_sms_bank'] = $this->language->get('payment_method_sms_bank');
        $data['payment_method_card_bank'] = $this->language->get('payment_method_card_bank');
        $data['payment_method_sms_card'] = $this->language->get('payment_method_sms_card');
        $data['payment_method_card_bank_sms'] = $this->language->get('payment_method_card_bank_sms');
        $data['payment_method_sms_inv'] = $this->language->get('payment_method_sms_inv');
        $data['payment_method_bank_inv'] = $this->language->get('payment_method_bank_inv');
        $data['payment_method_card_inv'] = $this->language->get('payment_method_card_inv');
        $data['payment_method_sms_bank_inv'] = $this->language->get('payment_method_sms_bank_inv');
        $data['payment_method_sms_card_inv'] = $this->language->get('payment_method_sms_card_inv');       
        $data['payment_method_inv_car_ban'] = $this->language->get('payment_method_inv_car_ban');
        $data['payment_method_sms_bank_card_inv'] = $this->language->get('payment_method_sms_bank_card_inv');       
        $data['payment_method_none']= $this->language->get('payment_method_none');
        
        $data['paysondirect_method_mode'] = $this->language->get('payment_method_mode');
        $data['paysondirect_mode'] = $this->language->get('payment_mode');
        $data['paysondirect_method_mode_live'] = $this->language->get('payment_method_mode_live');
        $data['paysondirect_method_mode_sandbox'] = $this->language->get('payment_method_mode_sandbox');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_total'] = $this->language->get('entry_total');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_order_item_details_to_ignore'] = $this->language->get('entry_order_item_details_to_ignore');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_totals_to_ignore'] = $this->language->get('entry_totals_to_ignore');

        $data['entry_show_receipt_page'] = $this->language->get('entry_show_receipt_page');
        $data['entry_show_receipt_page_yes'] = $this->language->get('entry_show_receipt_page_yes');
        $data['entry_show_receipt_page_no'] = $this->language->get('entry_show_receipt_page_no');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        
        
        
        
        $data['help_method_mode'] = $this->language->get('help_method_mode');
        $data['help_user_name'] = $this->language->get('help_user_name');
        $data['help_agent_id'] = $this->language->get('help_agent_id');
        $data['help_md5'] = $this->language->get('help_md5');
        $data['help_method_card_bank_info'] = $this->language->get('help_method_card_bank_info');
        $data['help_secure_word'] = $this->language->get('help_secure_word');
        $data['help_logg'] = $this->language->get('help_logg');
        $data['help_total'] = $this->language->get('help_total');
        $data['help_totals_to_ignore'] = $this->language->get('help_totals_to_ignore');       
        

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['user_name'])) {
            $data['error_user_name'] = $this->error['user_name'];
        } else {
            $data['error_user_name'] = '';
        }

        if (isset($this->error['agent_id'])) {
            $data['error_agent_id'] = $this->error['agent_id'];
        } else {
            $data['error_agent_id'] = '';
        }

        if (isset($this->error['md5'])) {
            $data['error_md5'] = $this->error['md5'];
        } else {
            $data['error_md5'] = '';
        }

        if (isset($this->error['ignored_order_totals'])) {
            $data['error_ignored_order_totals'] = $this->error['ignored_order_totals'];
        } else {
            $data['error_ignored_order_totals'] = '';
        }

        $data['error_invoiceFeeError'] = (isset($this->error['invoiceFeeError']) ? $this->error['invoiceFeeError'] : '');


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/paysondirect', 'token=' . $this->session->data['token'], true),
        );

        $data['action'] = $this->url->link('extension/payment/paysondirect', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        
        if (isset($this->request->post['paysondirect_modul_version'])) {
            $data['paysondirect_modul_version'] = $this->request->post['paysondirect_modul_version'];
        } else {
            $data['paysondirect_modul_version'] = $this->config->get('paysondirect_modul_version');
        }
        
        
        
        if (isset($this->request->post['paysondirect_user_name'])) {
            $data['paysondirect_user_name'] = $this->request->post['paysondirect_user_name'];
        } else {
            $data['paysondirect_user_name'] = $this->config->get('paysondirect_user_name');
        }

        if (isset($this->request->post['paysondirect_agent_id'])) {
            $data['paysondirect_agent_id'] = $this->request->post['paysondirect_agent_id'];
        } else {
            $data['paysondirect_agent_id'] = $this->config->get('paysondirect_agent_id');
        }
        if (isset($this->request->post['paysondirect_md5'])) {
            $data['paysondirect_md5'] = $this->request->post['paysondirect_md5'];
        } else {
            $data['paysondirect_md5'] = $this->config->get('paysondirect_md5');
        }

        if (isset($this->request->post['paysondirect_mode'])) {
            $data['paysondirect_mode'] = $this->request->post['paysondirect_mode'];
        } else {
            $data['paysondirect_mode'] = $this->config->get('paysondirect_mode');
        }
        $data['paysoninvoice_fee_fee'] = (isset($this->request->post['paysoninvoice_fee_fee']) ? $this->request->post['paysoninvoice_fee_fee'] : $this->config->get('paysoninvoice_fee_fee'));
        
        if (isset($this->request->post['paysondirect_payment_method'])) {
            $data['paysondirect_payment_method'] = $this->request->post['paysondirect_payment_method'];
        } else {
            $data['paysondirect_payment_method'] = $this->config->get('paysondirect_payment_method');
        }

        if (isset($this->request->post['paysondirect_secure_word'])) {
            $data['paysondirect_secure_word'] = $this->request->post['paysondirect_secure_word'];
        } else {
            $data['paysondirect_secure_word'] = $this->config->get('paysondirect_secure_word');
        }

        if (isset($this->request->post['paysondirect_logg'])) {
            $data['paysondirect_logg'] = $this->request->post['paysondirect_logg'];
        } else {
            $data['paysondirect_logg'] = $this->config->get('paysondirect_logg');
        }

        if (isset($this->request->post['paysondirect_total'])) {
            $data['paysondirect_total'] = $this->request->post['paysondirect_total'];
        } else {
            $data['paysondirect_total'] = $this->config->get('paysondirect_total');
        }

        if (isset($this->request->post['paysondirect_order_status_id'])) {
            $data['paysondirect_order_status_id'] = $this->request->post['paysondirect_order_status_id'];
        } else {
            $data['paysondirect_order_status_id'] = $this->config->get('paysondirect_order_status_id');
        }

        $data['paysondirect_invoice_status_id'] = (isset($this->request->post['paysondirect_invoice_status_id']) ? $this->request->post['paysondirect_invoice_status_id'] : $this->config->get('paysondirect_invoice_status_id'));

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['paysondirect_geo_zone_id'])) {
            $data['paysondirect_geo_zone_id'] = $this->request->post['paysondirect_geo_zone_id'];
        } else {
            $data['paysondirect_geo_zone_id'] = $this->config->get('paysondirect_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['paysondirect_status'])) {
            $data['paysondirect_status'] = $this->request->post['paysondirect_status'];
        } else {
            $data['paysondirect_status'] = $this->config->get('paysondirect_status');
        }

        if (isset($this->request->post['paysondirect_sort_order'])) {
            $data['paysondirect_sort_order'] = $this->request->post['paysondirect_sort_order'];
        } else {
            $data['paysondirect_sort_order'] = $this->config->get('paysondirect_sort_order');
        }

        if (isset($this->request->post['paysondirect_receipt'])) {
            $data['paysondirect_receipt'] = $this->request->post['paysondirect_receipt'];
        } else {
            $data['paysondirect_receipt'] = $this->config->get('paysondirect_receipt');
        }
        if (isset($this->request->post['paysondirect_ignored_order_totals'])) {
            $data['paysondirect_ignored_order_totals'] = $this->request->post['paysondirect_ignored_order_totals'];
        } else {
            if ($this->config->get('paysondirect_ignored_order_totals') == null) {
                $data['paysondirect_ignored_order_totals'] = 'sub_total, total, tax';
            } else
                $data['paysondirect_ignored_order_totals'] = $this->config->get('paysondirect_ignored_order_totals');
        }       
        
        $data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');

	$this->response->setOutput($this->load->view('extension/payment/paysondirect.tpl', $data));
    }

    private function validate() {

        if (!$this->user->hasPermission('modify', 'extension/payment/paysondirect')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->request->post['paysondirect_mode'] != 0) {          
            if (!isset($this->request->post['paysondirect_agent_id']) || !$this->request->post['paysondirect_agent_id']) {
                $this->error['agent_id'] = $this->language->get('error_agent_id');
            }

            if (!isset($this->request->post['paysondirect_user_name']) || !$this->request->post['paysondirect_user_name']) {
                $this->error['user_name'] = $this->language->get('error_user_name');
            }
            if (!isset($this->request->post['paysondirect_md5']) || !$this->request->post['paysondirect_md5']) {
                $this->error['md5'] = $this->language->get('error_md5');
            }
            
            
            
        }
        if (!$this->request->post['paysondirect_ignored_order_totals']) {
            $this->error['ignored_order_totals'] = $this->language->get('error_ignored_order_totals');
        }

       if (isset($this->request->post['paysoninvoice_fee_fee'])) {
            if (!is_numeric($this->request->post['paysoninvoice_fee_fee'])) {
                $this->error['invoiceFeeError'] = "Invoicefee must be a number";
            } else {
                if ($this->request->post['paysoninvoice_fee_fee'] < 0 || $this->request->post['paysoninvoice_fee_fee'] > 40) {
                    $this->error['invoiceFeeError'] = "Invoicefee must be between 0-40";
                }
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    
    public function install() {           
		$this->load->model('extension/payment/paysondirect');

		$this->model_extension_payment_paysondirect->install();
    }

}

?>