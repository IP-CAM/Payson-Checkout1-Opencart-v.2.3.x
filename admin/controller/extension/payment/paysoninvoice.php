<?php

class ControllerExtensionPaymentPaysoninvoice extends Controller {

    private $error = array();

    public function index() {

        $this->load->language('extension/payment/paysoninvoice');
        
        $this->load->model('setting/setting');
        //Save the settings if the user has submitted the admin form (ie if someone has pressed save).		
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('paysoninvoice', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }        

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit']       = $this->language->get('text_edit');
        $data['config_message'] = $this->language->get('config_message');

        $data['link_to_paysondirect'] = $this->url->link('extension/paysondirect', 'token=' . $this->session->data['token'], 'SSL');

        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_order_status'] = $this->language->get('entry_order_status');	
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['action'] = $this->url->link('extension/payment/paysoninvoice', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        if (isset($this->request->post['paysoninvoice_status'])) {
            $data['paysoninvoice_status'] = $this->request->post['paysoninvoice_status'];
        } else {
            $data['paysoninvoice_status'] = $this->config->get('paysoninvoice_status');
        }

        if (isset($this->request->post['paysoninvoice_sort_order'])) {
            $data['paysoninvoice_sort_order'] = $this->request->post['paysoninvoice_sort_order'];
        } else {
            $data['paysoninvoice_sort_order'] = $this->config->get('paysoninvoice_sort_order');
        }
        
        if (isset($this->request->post['paysoninvoice_order_status_id'])) {
			$data['paysoninvoice_order_status_id'] = $this->request->post['paysoninvoice_order_status_id'];
		} else {
			$data['paysoninvoice_order_status_id'] = $this->config->get('paysoninvoice_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
      
         if (isset($this->request->post['paysoninvoice_geo_zone_id'])) {
		$data['paysoninvoice_geo_zone_id'] = $this->request->post['paysoninvoice_geo_zone_id'];
	} else {
		$data['paysoninvoice_geo_zone_id'] = $this->config->get('paysoninvoice_geo_zone_id'); 
	} 
		
	$this->load->model('localisation/geo_zone');						
		
	$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();     
                
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token==' . $this->session->data['token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/extension', 'token==' . $this->session->data['token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/paysoninvoice', 'token==' . $this->session->data['token'], true),
            'separator' => ' :: '
        );      
        
        $data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');

	$this->response->setOutput($this->load->view('extension/payment/paysoninvoice.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/paysoninvoice')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
     
        return !$this->error;
        
    }

}

?>