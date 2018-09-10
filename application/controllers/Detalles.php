<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Detalles extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_directorio',"",TRUE);
	}
	/*
	public function index_get()
	{	
		$subs = $this->m_social->obtImagenComplemento();
		
		if(count($subs) > 0)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'No hay registros'),404);
		}
	}
	*/
	public function find_get($id)
	{		
	
		if(!$id)
		{
			$this->response(null,400);
		}
		
		$subs = $this->m_directorio->obtImagenComplemento($id);
		
		if($subs)
		{
			$this->response(array('response' => $subs),200);
		}
		else
		{
			$this->response(array('error' => 'Subscriptor no encontrado'),404);
		}
	}
	/*
	public function index_post()
	{	
		$postdata = file_get_contents("php://input");
		if (isset($postdata))
		{
			$request = json_decode($postdata);
			
			$nombre = $request->nombre;
			$password = md5($request->password);
			$correo = $request->correo;
		}
		
		if(!$this->post('nombre'))
		{
			//$this->response(null,400);
			$this->response(array('error' => 'no se encontro la variable'),400);
		}
		
		$nombre = $this->post('nombre');
		
		$id = $this->m_subscriptores->registrar($nombre,$correo,$password);
		
		if(!is_null($id))
		{
			$this->response(array('response' => $id),200);
		}
		else
		{
			$this->response(array('error' => 'Algo salio mal'),400);
		}
		
	}*/
	/*
	
	public function index_put($id)
	{	
		if(!$this->put('nombre') || !$id || $this->put('nombre') == "" || $id == "" || $id == "0")
		{
			$this->response(null,400);
		}
		
		try
		{
			$this->m_subscriptores->actualizar($id, $this->put('nombre'));
		}
		catch(Exception $e) 
		{
			$this->response(array('error' => 'Algo salio mal'),400);
		}
		
		$this->response(array('response' => "subscriptor actualizado"),200);
		
	}
	
	public function index_delete($id)
	{	
		if(!$id)
		{
			$this->response(null,400);
		}
		
		$id = $this->m_subscriptores->eliminar($id);
		
		$this->response(array('response' => "subscriptor eliminado"),200);
	}
	
	public function correo()
	{	
		die(var_dump($this->post('correo')." HOLA"));
	
		if(!$this->post('correo'))
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
	*/
}
?>