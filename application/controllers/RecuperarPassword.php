<?php

 header('Access-Control-Allow-Origin: *'); 

defined('BASEPATH') OR exist('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class RecuperarPassword extends REST_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');            
		$this->load->model('m_subscriptores',"",TRUE);
	}
	
	public function find_get($datos)
	{		
		$datos = explode("-",$datos);
		
		$operacion = $datos[0];
		$correo = $datos[1];
		$clave = $datos[2];
	
		if(!$correo)
		{
			$this->response(null,400);
		}

		$sub = $this->m_subscriptores->obt_subscriptor_correo($correo);

		if($sub)
		{
			if($operacion == 1)
			{
				$clave = $this->RamdowClave();
			
				$this->m_subscriptores->iniciarprocesorecuperacion($sub->id, $clave);
				
				$this->enviar_correo($sub->nombre, $sub->correo, "Recuperación de contraseña", $clave);
				
				$this->response(array('response' => $sub),200);
			}			
			else if($operacion == 2)
			{
				$n = $this->m_subscriptores->validarrecuperacion($sub->id, $clave);
				
				$this->response(array('response' => $n),200);
			}		
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
			
			$password = md5($request->password);
			$correo = $request->correo;
		}
		
		$this->m_subscriptores->cambiarpassword($correo,$password);
		
		if(!is_null($correo))
		{
			$this->response(array('response' => 1),200);
		}
		else
		{
			$this->response(array('error' => 'Algo salio mal'),400);
		}
	}
	
	function RamdowClave()
	{
		$length = 8;
		
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	
	function enviar_correo($nombre, $correo, $titulo, $clave)
	{
		$fecha = date("Y-m-d H:i");
		
		$this->load->library('email');
		
		$config['charset'] = 'utf-8';
		$config['mailtype'] = 'html';
		
		$this->email->initialize($config);
		$this->email->from('info@easyclick.com.mx', 'info@easyclick.com.mx');
		$this->email->to('martinsystech@gmail.com');					
		$this->email->subject("Recuperación contraseña");
		
		$body = '
			<meta charset="UTF-8">
			<div style="margin:0;padding:0;border:0">
			 
			  <table width="670" align="center" border="0" cellspacing="0" cellpadding="0">
				<tbody>
				  <tr>
					<td align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
					</td>
					<td>
					  <table align="center" border="0" width="660" cellpadding="0" cellspacing="0">
						<tbody>
						  <tr>
							<td align="left" bgcolor="#FFFFFF" height="38" valign="middle" width="560" style="font-family:Helvetica,sans-serif;font-size:10px;line-height:20px;color:#505050;font-weight:none;text-decoration:none">
							</td>
						  </tr>
						</tbody>
					  </table>
					  <table bgcolor="#FFFFFF" align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td width="220">
							 
							</td>
							<td align="center">
							  <a href="#m_-1006208671590304086_" style="color:#5887f5;font-weight:bold">
								<img style="display:block" alt="PlayStation" title="PlayStation" border="0" src="http://www.easyclick.xyz//src/images/easyclick_app.png"
								  width="438" height="65" class="CToWUd">
							  </a>
							</td>
							<td width="220">
							
							</td>
						  </tr>
						</tbody>
					  </table>
					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							
							</td>
						  </tr>
						</tbody>
					  </table>
					  <br>
					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td align="center" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#323232">
							  <span style="font-size:30px;line-height:50px">'.$titulo.'</span>
							  <br>
							  <br> Apreciado/a '.$nombre.':
							  <br>
							  <br>Iniciaste un proceso de recuperación de contraseña
							  <br>
							  <br>A continuación te enviamos la información para continuar con el proceso</td>
						  </tr>
						</tbody>
					  </table>
					 <br>
					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td width="40" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>

							<td width="300" align="left" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#323232">
							  <span style="font-size:22px;line-height:50px">
								<a href="#m_-1006208671590304086_" style="font-size:22px;line-height:50px;text-decoration:none;color:#323232">Clave de recuperación :&nbsp; '.$clave.' </a>
							  </span>
							</td>
							<td bgcolor="#575756" width="15" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							  
							</td>
							<td bgcolor="#575756" width="270" align="right" style="margin:0;padding:0;font-size:0;line-height:0;border:0;font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#fff">
							  <div style="line-height:15px;margin:0;padding:0;border:0"> &nbsp; </div> 
							  <div style="line-height:2px;margin:0;padding:0;border:0"> &nbsp; </div>Fecha del solicitud de proceso <br>'.$fecha.'
							  <div style="line-height:15px;margin:0;padding:0;border:0">
							  &nbsp; </div>
							</td>
							<td width="15" bgcolor="#575756" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0"></td>
							<td width="20" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0"></td>
						  </tr>
						</tbody>
					  </table>
				   <!--
					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td width="20" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							  
							</td>
							<td width="20" bgcolor="#1e1e1e" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
							<td width="492" bgcolor="#1e1e1e" align="left" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#ffffff;font-weight:bold">
							  <div style="line-height:15px;margin:0;padding:0;border:0"> &nbsp; </div>Detalles
							  <div style="line-height:15px;margin:0;padding:0;border:0"> &nbsp; </div>
							</td>
							<td bgcolor="#ffffff" width="15" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							  
							</td>
							<td bgcolor="#1e1e1e" width="72" align="right" style="margin:0;padding:0;font-size:0;line-height:0;border:0;font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#ffffff;font-weight:bold">
							  <div style="line-height:15px;margin:0;padding:0;border:0"> &nbsp; </div> Precio
							  <div style="line-height:15px;margin:0;padding:0;border:0"> &nbsp; </div>
							</td>
							<td width="20" bgcolor="#1e1e1e" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
							<td width="21" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							
							</td>
						  </tr>
						</tbody>
					  </table>
					  
					 
					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td width="20" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
							<td width="20" bgcolor="#ffffff" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0;border-bottom:1px solid #d2d2d2">
							  
							</td>
							<td width="492" bgcolor="#ffffff" align="left" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;border-bottom:1px solid #d2d2d2">
							  <div style="line-height:20px;margin:0;padding:0;border:0"> &nbsp; </div>
							  <a href="#m_-1006208671590304086_" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;text-decoration:none">Amazon Prime Video (Application) </a>
							  <div style="line-height:2px;margin:0;padding:0;border:0"> &nbsp; </div>
							  <div style="line-height:20px;margin:0;padding:0;border:0"> &nbsp; </div>
							</td>
							<td bgcolor="#ffffff" width="15" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
							<td bgcolor="#ffffff" width="72" align="right" style="margin:0;padding:0;font-size:0;line-height:0;border:0;font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#505050;font-weight:none;border-bottom:1px solid #d2d2d2">
							  <div style="line-height:20px;margin:0;padding:0;border:0"> &nbsp; </div>US$0.00
							  <div style="line-height:20px;margin:0;padding:0;border:0"> &nbsp; </div>
							</td>
							<td width="20" bgcolor="#ffffff" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0;border-bottom:1px solid #d2d2d2">
							  
							</td>
							<td width="21" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							  
							</td>
						  </tr>
						</tbody>
					  </table>


					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
						  </tr>
						</tbody>
					  </table>





					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td width="20" height="41" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
							<td width="20" bgcolor="#ffffff" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
							<td width="379" valign="top" bgcolor="#ffffff" align="left" style="font-family:Helvetica,sans-serif;font-size:20px;line-height:20px;color:#505050;font-weight:none">

							  Cantidad actual en el monedero*:&nbsp;US$0.00
							  <div style="line-height:1px;margin:0;padding:0;border:0">
							  &nbsp; </div>
							  <em>
								<span style="font-size:10px">*Estos fondos del monedero corresponden a la cantidad actual en la fecha y hora de la transacción.</span>
							  </em>

							</td>
							<td bgcolor="#ffffff" width="23" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							  
							</td>
							<td bgcolor="#ffffff" width="176" align="right" valign="top" style="margin:0;padding:0;font-size:0;line-height:0;border:0;font-family:Helvetica,sans-serif;font-size:20px;line-height:20px;color:#505050;font-weight:none">
							  Total: &nbsp;US$0.00
							  <div style="line-height:2px;margin:0;padding:0;border:0">
								&nbsp; </div>
							</td>
							<td width="20" bgcolor="#ffffff" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>



							<td width="22" align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							 
							</td>
						  </tr>
						</tbody>
					  </table>

					 
					  -->


					  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
							<td width="20" height="60" align="left" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							
							</td>

							<td align="left" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#323232">

							  <table align="center" width="660" border="0" cellspacing="0" cellpadding="0">
								<tbody>
								  <tr>
									<td width="20" height="60" align="left" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
									  
									</td>
									<td align="left" style="font-family:Helvetica,sans-serif;font-size:13px;line-height:20px;color:#323232">
									  <br>
									  <br> Este mensaje de correo electrónico se ha enviado desde una dirección exclusivamente para envíos. No responda a este mensaje.
									  <br>
									  <br>
									  <!--
									  <br>Términos de Uso y Política de Privacidad:
									  <br>
									  <a href="https://www.playstationnetwork.com/legal" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=es&amp;q=https://www.playstationnetwork.com/legal&amp;source=gmail&amp;ust=1519741110105000&amp;usg=AFQjCNH14sI_H3dr-kqpMoZC-8jk2yiCEA">https://www.<wbr>playstationnetwork.com/legal</a>
									  <br>
									  -->
									  <table>
										<tbody>
										  <tr>
											<td height="15">EAYCLICK.</td>
										  </tr>
										</tbody>
									  </table>

									  <table>
										<tbody>
										  <tr>
											<td height="15">© 2018 easyclick.xyz .</td>
										  </tr>
										</tbody>
									  </table>
									</td>
									<td width="20" height="60" align="left" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
									  
									</td>
								  </tr>
								</tbody>
							  </table>


							</td>
							<td width="20" height="60" align="left" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
							  
							</td>
						  </tr>
						</tbody>
					  </table>
					 
					</td>
					<td align="center" style="margin:0;padding:0;font-size:0;line-height:0;border:0">
					  
					</td>
				  </tr>
				</tbody>
			  </table>
			  <div class="yj6qo">
			  </div>
			  <div class="adL">
			  </div>
			</div>';
			
		$this->email->message($body);            
		$this->email->send();
	}
}
?>