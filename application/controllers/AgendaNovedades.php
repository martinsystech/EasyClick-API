<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class AgendaNovedades extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_subscriptores',"",TRUE);
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
			$tipo = $request->tipo;
		}
		
		if($tipo == 2) //OFERTA
		{
			if($estado == 1 || $estado == null || $estado == "")
			{
				$n_registros = $this->m_subscriptores->validar_oferta($subscriptor,$anuncio);
			
				if($n_registros > 0)
				{
					$this->m_subscriptores->activar_oferta($subscriptor,$anuncio);
					
					$id = 1;
				}
				else
				{
					$id = $this->m_subscriptores->agregar_oferta($subscriptor,$anuncio);
				}
			}
			else
			{
				$this->m_subscriptores->eliminar_oferta($subscriptor,$anuncio);
				
				$id = 0;
			}
		}
		
		if($tipo == 3) //EVENTO
		{
			if($estado == 1 || $estado == null || $estado == "")
			{
				$n_registros = $this->m_subscriptores->validar_evento($subscriptor,$anuncio);
			
				if($n_registros > 0)
				{
					$this->m_subscriptores->activar_evento($subscriptor,$anuncio);
					
					$id = 1;
				}
				else
				{
					$id = $this->m_subscriptores->agregar_evento($subscriptor,$anuncio);
				}
			}
			else
			{
				$this->m_subscriptores->eliminar_evento($subscriptor,$anuncio);
				
				$id = 0;
			}
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
	

}
?>