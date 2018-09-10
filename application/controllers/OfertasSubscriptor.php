<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class OfertasSubscriptor extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_subscriptores',"",TRUE);
	}
	
	
	public function find_get($id)
	{		
		if(!$id)
		{
			$this->response(null,400);
		}
		
		$subs = $this->m_subscriptores->obt_ofertas($id);
		
		if($subs)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'Subscriptor no encontrado'),404);
		}
	}
	
}
?>