<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Vistas extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_comentarios',"",TRUE);
	}
	
	public function find_get($datos)
	{	
		$datos = explode("-",$datos);
		
		$tipo = $datos[0];
		$id = $datos[1];
	
		if(!$id)
		{
			$this->response(null,400);
		}
		
		$subs = $this->m_comentarios->GetNoVistas($tipo, $id);
		
		if($subs)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'Sin visitas'),404);
		}
	}
	
	
	public function index_post()
	{	
		$postdata = file_get_contents("php://input");

		if (isset($postdata))
		{
			$request = json_decode($postdata);

			$tipo = $request->tipo;
			$anuncio = $request->anuncio;
			$subscriptor = $request->subscriptor;
		}
		
		if(!$subscriptor)
		{
			$this->response(array('error' => 'no se encontraron datos de envio'),400);
		}
		else
		{
			$id = $this->m_comentarios->ver($tipo, $anuncio, $subscriptor);
		}
		
			$subs = $this->m_comentarios->GetNoVistas($tipo, $anuncio);
			
			$this->response(array('response' => $subs),200);
		
		
			$this->response(array('error' => 'Algo salio mal'),400);
			
	}
	
	
}
?>