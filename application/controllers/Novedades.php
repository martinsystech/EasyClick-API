<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Novedades extends REST_Controller {
 
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
		$giro = $datos[1];
		$categoria = $datos[2];
		$estado = $datos[3];
		$municipio = $datos[4];
		$busqueda = $datos[5];

		if(!$datos)
		{
			$this->response(null,400);
		}
		
		$sub = $this->m_directorio->Getnovedades($tipo, $giro , $categoria, $estado, $municipio, $busqueda);

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