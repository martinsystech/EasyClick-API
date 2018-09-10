<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Inicio extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_directorio',"",TRUE);
	}

	public function find_get($datos)
	{		
		$datos = explode("-",$datos);
		
		$tipo = $datos[0];
		$tiponovedad = $datos[1];
		$estado = $datos[2];
		$municipio = $datos[3];

		if(!$datos)
		{
			$this->response(null,400);
		}
		
		if($tipo == 1)
		{
			$sub = $this->m_directorio->GetAnunciosInicio($estado, $municipio);
		}
		if($tipo == 2)
		{
			$sub = $this->m_directorio->GetNovedadesInicio($tiponovedad, $estado, $municipio);
		}

		if($sub)
		{
			$this->response(array('response' => $sub),200);
		}
		else
		{
			$this->response(array('response' => $sub),200);
		}
	}
	
	
}
?>