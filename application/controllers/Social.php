<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Social extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_directorio',"",TRUE);
	}
	
	public function index_get()
	{	
		$subs = $this->m_directorio->obt_anuncios(7);
		
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
		
		$sub = $this->m_directorio->obt_anuncio($id);

		if($sub)
		{
			$this->response(array('response' => $sub),200);
		}
		else
		{
			$this->response(array('error' => 'Subscriptor no encontrado'),404);
		}
	}
	
	
}
?>