<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Directorio extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_directorio',"",TRUE);
	}
	
	public function index_get()
	{	
		$subs = $this->m_directorio->GetAnuncios(7);
		
		if(count($subs) > 0)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'No hay registros'),404);
		}
	}
	
	public function find_get($datos)
	{		
		$datos = explode("-",$datos);
		
		$giro = $datos[0];
		$categoria = $datos[1];
		$estado = $datos[2];
		$municipio = $datos[3];
		$busqueda = $datos[4];

		if(!$datos)
		{
			$this->response(null,400);
		}
		
		$sub = $this->m_directorio->GetAnuncios($giro , $categoria, $estado, $municipio, $busqueda);

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