<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Ubicacion extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_ubicacion',"",TRUE);
	}
	
	public function index_get()
	{	
		$subs = $this->m_ubicacion->obt_estados();
		
		if(count($subs) > 0)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'No hay registros'),404);
		}
	}
	
	public function find_get($id)
	{		
	
		if(!$id)
		{
			$this->response(null,400);
		}
		
		$subs = $this->m_ubicacion->obt_municipios($id);
		
		if($subs)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'registro no encontrado'),404);
		}
	}
	
}
?>