<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Agenda extends REST_Controller {
 
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
		
		$subs = $this->m_subscriptores->obt_agenda($id);

		if($subs)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'Subscriptor no encontrado'),404);
		}
	}
	
	public function index_post()
	{	
		$postdata = file_get_contents("php://input");

		if (isset($postdata))
		{
			$request = json_decode($postdata);
			
			$subscriptor = $request->subscriptor;
			$anuncio = $request->anuncio;
			$estado = $request->estado;
		}
		
		if($estado == 1 || $estado == null || $estado == "")
		{
			$n_registros = $this->m_subscriptores->validar_agenda($subscriptor,$anuncio);
		
			if($n_registros > 0)
			{
				$this->m_subscriptores->activar_agenda($subscriptor,$anuncio);
				
				$id = 1;
			}
			else
			{
				$id = $this->m_subscriptores->agregar_agenda($subscriptor,$anuncio);
			}
		}
		else
		{
			$this->m_subscriptores->eliminar_agenda($subscriptor,$anuncio);
			
			$id = 0;
		}
		
		
		
		if(!is_null($id))
		{
			if($id == 1)
			{
				$this->response(array('correcto' => 'registro acivado'.$estado),200);
			}
			else if($id == 0)
			{
				$this->response(array('correcto' => 'registro eliminado'),200);
			}
			else
			{
				$this->response(array('correcto' => 'registro registrado'),200);
			}
		}
		else
		{
			$this->response(array('error' => 'Algo salio mal'),400);
		}
	}
	
	public function index_put()
	{	
		$postdata = file_get_contents("php://input");

		if (isset($postdata))
		{
			$request = json_decode($postdata);
			
			$subscriptor = $request->subscriptor;
			$anuncio = $request->anuncio;
		}
		
		try
		{
			$this->m_subscriptores->eliminar_agenda($subscriptor,$anuncio);
		}
		catch(Exception $e) 
		{
			$this->response(array('error' => 'Algo salio mal'),400);
		}
		
		$this->response(array('response' => "registro actualizado"),200);
		
	}
	
	public function index_delete($id)
	{	
		if(!$id)
		{
			$this->response(null,400);
		}
		
		$id = $this->m_subscriptores->eliminar_agenda($id);
		
		$this->response(array('response' => "registro eliminado"),200);
	}
	
}
?>