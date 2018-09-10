<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Estrellas extends REST_Controller {
 
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
		
		$subs = $this->m_comentarios->GetNoEstrellas($tipo, $id);
		
		if($subs)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'Sin valoraciones'),404);
		}
	}
	
	
	public function index_post()
	{	
		$postdata = file_get_contents("php://input");

		if (isset($postdata))
		{
			$request = json_decode($postdata);

			$subscriptor = $request->subscriptor;
			$tipo = $request->tipo;
			$anuncio = $request->anuncio;
			$estrellas = $request->estrellas;
		}
		
		if(!$subscriptor)
		{
			$this->response(array('error' => 'no se encontraron datos de envio'),400);
		}
		else
		{
			$n = $this->m_comentarios->validar_valoracion($tipo, $subscriptor, $anuncio);
			
			if($n == 0)
			{
				$this->m_comentarios->guardar_valoracion($tipo, $anuncio, $subscriptor, $estrellas);
			}
			else
			{
				$this->m_comentarios->actualizar_valoracion($tipo, $anuncio, $subscriptor, $estrellas);
			}
			
			$stars = $this->m_comentarios->obt_valoraciones($tipo,$anuncio);
		
			$n_valoraciones = count($stars);
			$n_stars = 0;
			
			foreach($stars as $star)
			{
				$n_stars = $n_stars + $star->estrellas;
			}
			
			$valoracion = round(($n_stars / $n_valoraciones),0);
			
			if($tipo == 1)
			{
				$this->m_comentarios->actualizar_valoracion_empresa($anuncio, $valoracion);
			}
			else
			{
				$this->m_comentarios->actualizar_valoracion_novedad($anuncio, $valoracion);
			}
			
		}
		
			$this->response(array('response' => $valoracion),200);
		
	}
	
}
?>