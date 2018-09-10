<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class ValidarAgenda extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_subscriptores',"",TRUE);
	}

	public function find_get($datos)
	{		
		$datos = explode("-",$datos);
		
		$subscriptor = $datos[0];
		$tipo = $datos[1];
		$anuncio = $datos[2];

		if(!$subscriptor)
		{
			$this->response(null,400);
		}
		
		$sub = 0;
		
		if($tipo == 1)
		{
			$sub = $this->m_subscriptores->validar_agenda_activo($subscriptor, $anuncio);
		}
		else if($tipo == 2)
		{
			$sub = $this->m_subscriptores->validar_ofertas_activo($subscriptor, $anuncio);
		}
		else if($tipo == 3)
		{
			$sub = $this->m_subscriptores->validar_evento_activo($subscriptor, $anuncio);
		}

		
		$this->response(array('response' => $sub),200);
		
	}
	
	public function index_post()
	{	
		if(!$this->post('nombre'))
		{
			$this->response(null,400);
		}
		
		$nombre = $this->post('nombre');

		$id = $this->m_subscriptores->registrar($nombre);
		
		if(!is_null($id))
		{
			$this->response(array('response' => $id),200);
		}
		else
		{
			$this->response(array('error' => 'Algo salio mal'),400);
		}
	}

}
?>