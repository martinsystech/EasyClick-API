<?php

class M_Subscriptores extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }
	 
	function registrar($nombre,$correo,$password)
	{
		$this->nombre = $nombre;
		$this->correo = $correo;
		$this->password = $password;
		$this->activo = 1;

        $this->db->insert("Tb_Subscriptores",$this);  

		return $this->db->insert_id();
	}
	
	function actualizar($id, $nombre)
	{
		$this->db->set("nombre",$nombre);
		
        $this->db->where("id",$id);        
        $this->db->update("Tb_Subscriptores"); 
	}
	
	function eliminar($id)
	{
		$this->db->set("activo",0);
		
        $this->db->where("id",$id);        
        $this->db->update("Tb_Subscriptores"); 
	}
	
	function obt_Subscriptores()
	{
		return $this->db->get("Tb_Subscriptores")->result();
	}
	
	function obt_subscriptor($id)
	{
		$this->db->where("id",$id);	
		return $this->db->get("Tb_Subscriptores")->row();
	}
	
	function obt_subscriptor_correo($id)
	{
		$this->db->where("correo",$id);	
		return $this->db->get("Tb_Subscriptores")->row();
	}
	
	function iniciarprocesorecuperacion($id, $clave)
	{
		$this->db->set("recuperacionpassword",1);
		$this->db->set("claverecuperacion",$clave);
		
        $this->db->where("id",$id);        
        $this->db->update("Tb_Subscriptores"); 
	}
	
	function validarrecuperacion($id, $clave)
	{
		$this->db->where("id",$id);
		$this->db->where("claverecuperacion",$clave);		
		
		return $this->db->get("Tb_Subscriptores")->num_rows();
	}
	
	function cambiarpassword($correo, $password)
	{
		$this->db->set("password",$password);
		$this->db->set("recuperacionpassword",0);
		$this->db->set("claverecuperacion",null);
		
        $this->db->where("correo",$correo);        
        $this->db->update("Tb_Subscriptores"); 
	}
	
	function obt_agenda($id)
	{
		$qry ="";
		$qry .= "
		
			SELECT 

				T0.id as idagenda
				,T0.idAnuncio as id
				,DATE_FORMAT(T0.fecha, '%d/%m/%Y %H:%i') as fecha 
				,T1.nombre
				,T1.eslogan
				,T2.opcion as giro
				,T3.nombre as estado
				,T4.nombre as municipio
			FROM Db_Easyclick.Tb_AnunciosSubscriptor T0
			LEFT JOIN Db_Easyclick.Tb_Empresas T1 ON T1.id = T0.idAnuncio
			LEFT JOIN Db_Easyclick.Tb_CatGiros T2 ON T2.id = T1.giro
			LEFT JOIN Db_Easyclick.Tb_CatEstado T3 ON T3.id = T1.estado
			LEFT JOIN Db_Easyclick.Tb_CatMunicipios T4 ON T4.id = T1.municipio

			WHERE T0.estado = 1 and T0.subscriptor = ".$id." 

			ORDER BY T0.fecha desc;		
					";
							
        return $this->db->query($qry)->result();     
	}
	
	function obt_eventos($id)
	{
		$qry ="";
		$qry .= "
		
			SELECT 

				T0.id
				,DATE_FORMAT(T0.fecha, '%d/%m/%Y %H:%i') as fecha_registro
				,T1.id as IdEvento
				,T1.titulo
				,T2.nombre as empresa
				,DATE_FORMAT(T1.termino, '%d/%m/%Y') as fecha 
			FROM Db_Easyclick.Tb_EventosSubscriptor T0
			LEFT JOIN Db_Easyclick.Tb_Novedades T1 ON T1.id = T0.IdEvento AND T1.tipo = 2
			LEFT JOIN Db_Easyclick.Tb_Empresas T2 ON T2.id = T1.empresa

			WHERE T0.estado = 1 AND T0.subscriptor = ".$id." ;
		";
							
        return $this->db->query($qry)->result();     
	}
	
	function obt_ofertas($id)
	{
		$qry ="";
		$qry .= "
		
			SELECT 

				T0.id
				,DATE_FORMAT(T0.fecha, '%d/%m/%Y %H:%i') as fecha_registro 
				,T1.id as IdEvento
				,T1.titulo
				,T2.nombre as empresa
				,DATE_FORMAT(T1.termino, '%d/%m/%Y') as fecha 
			FROM Db_Easyclick.Tb_OfertasSubscriptor T0
			LEFT JOIN Db_Easyclick.Tb_Novedades T1 ON T1.id = T0.IdOferta AND T1.tipo = 1
			LEFT JOIN Db_Easyclick.Tb_Empresas T2 ON T2.id = T1.empresa

			WHERE T0.estado = 1 AND T0.subscriptor = ".$id." ;
		";
							
        return $this->db->query($qry)->result();     
	}
	
	function obt_novedad($id)
	{
		$qry ="";
		$qry .= "
		
			SELECT

				T0.id
				,DATE_FORMAT(T0.termino, '%d/%m/%Y') as fecha 
				,T3.nombre as tipo
				,T0.titulo
				,T0.latitud
				,T0.longitud
				,CONCAT(IFNULL(T0.calle,''),' ',IFNULL(T0.numero,''),' ',IFNULL(T0.colonia,''),' ',IFNULL(T0.cp,'')) as direccion
				,T0.valoracion
				,T0.contenido
				,T1.nombre as empresa
				,T1.id as idempresa
				,T2.opcion as giro
				,T4.nombre as orientacion 
				
			FROM Db_Easyclick.Tb_Novedades T0
			LEFT JOIN Db_Easyclick.Tb_Empresas T1 ON T1.id = T0.empresa
			LEFT JOIN Db_Easyclick.Tb_CatGiros T2 ON T2.id = T1.giro
			LEFT JOIN Db_Easyclick.Tb_CatTipoNovedad T3 ON T3.id = T0.tipo
			LEFT JOIN Db_Easyclick.Tb_CatOrientacionNovedad T4 ON T4.id = T0.orientacion

			WHERE T0.id = ".$id." ;
		";
							
        return $this->db->query($qry)->row();     
	}

	function validar_agenda($subscriptor, $anuncio)
	{
		$this->db->where("subscriptor",$subscriptor);
		$this->db->where("IdAnuncio",$anuncio);		
		return $this->db->get("Tb_AnunciosSubscriptor")->num_rows();
	}
	
	function validar_agenda_activo($subscriptor, $anuncio)
	{
		$this->db->where("subscriptor",$subscriptor);
		$this->db->where("IdAnuncio",$anuncio);		
		$this->db->where("estado",1);
		return $this->db->get("Tb_AnunciosSubscriptor")->num_rows();
	}
	
	function agregar_agenda($subscriptor,$anuncio)
	{
		$this->subscriptor = $subscriptor;
		$this->idanuncio = $anuncio;
		$this->estado = 1;

        $this->db->insert("Tb_AnunciosSubscriptor",$this);  

		return $this->db->insert_id();
	}
	
	function eliminar_agenda($subscriptor, $anuncio)
	{
		$this->db->set("estado",0);
		
        $this->db->where("subscriptor",$subscriptor); 
		$this->db->where("idanuncio",$anuncio); 		
        $this->db->update("Tb_AnunciosSubscriptor"); 
	}
	
	function activar_agenda($subscriptor, $anuncio)
	{
		$this->db->set("estado",1);
		
        $this->db->where("subscriptor",$subscriptor); 
		$this->db->where("idanuncio",$anuncio); 		
        $this->db->update("Tb_AnunciosSubscriptor"); 
	}
	
	
	
	function validar_ofertas_activo($subscriptor, $anuncio)
	{
		$this->db->where("subscriptor",$subscriptor);
		$this->db->where("IdOferta",$anuncio);		
		$this->db->where("estado",1);
		return $this->db->get("Tb_OfertasSubscriptor")->num_rows();
	}
	
	function validar_ofertas($subscriptor, $anuncio)
	{
		$this->db->where("subscriptor",$subscriptor);
		$this->db->where("IdOferta",$anuncio);		
		return $this->db->get("Tb_OfertasSubscriptor")->num_rows();
	}
	
	function agregar_oferta($subscriptor,$anuncio)
	{
		$this->subscriptor = $subscriptor;
		$this->IdOferta = $anuncio;
		$this->estado = 1;

        $this->db->insert("Tb_OfertasSubscriptor",$this);  

		return $this->db->insert_id();
	}
	
	function eliminar_oferta($subscriptor, $anuncio)
	{
		$this->db->set("estado",0);
		
        $this->db->where("subscriptor",$subscriptor); 
		$this->db->where("IdOferta",$anuncio); 		
        $this->db->update("Tb_OfertasSubscriptor"); 
	}
	
	function activar_oferta($subscriptor, $anuncio)
	{
		$this->db->set("estado",1);
		
        $this->db->where("subscriptor",$subscriptor); 
		$this->db->where("IdOferta",$anuncio); 		
        $this->db->update("Tb_OfertasSubscriptor"); 
	}
	
	
	
	
	function validar_evento_activo($subscriptor, $anuncio)
	{
		$this->db->where("subscriptor",$subscriptor);
		$this->db->where("IdEvento",$anuncio);		
		$this->db->where("estado",1);
		return $this->db->get("Tb_EventosSubscriptor")->num_rows();
	}

	function validar_evento($subscriptor, $anuncio)
	{
		$this->db->where("subscriptor",$subscriptor);
		$this->db->where("IdEvento",$anuncio);		
		return $this->db->get("Tb_EventosSubscriptor")->num_rows();
	}
	
	function agregar_evento($subscriptor,$anuncio)
	{
		$this->subscriptor = $subscriptor;
		$this->IdEvento = $anuncio;
		$this->estado = 1;

        $this->db->insert("Tb_EventosSubscriptor",$this);  

		return $this->db->insert_id();
	}
	
	function eliminar_evento($subscriptor, $anuncio)
	{
		$this->db->set("estado",0);
		
        $this->db->where("subscriptor",$subscriptor); 
		$this->db->where("IdEvento",$anuncio); 		
        $this->db->update("Tb_EventosSubscriptor"); 
	}
	
	function activar_evento($subscriptor, $anuncio)
	{
		$this->db->set("estado",1);
		
        $this->db->where("subscriptor",$subscriptor); 
		$this->db->where("IdEvento",$anuncio); 		
        $this->db->update("Tb_EventosSubscriptor"); 
	}
	
}
?>
