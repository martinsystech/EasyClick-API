<?php

class M_comentarios extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }

	function obt_comentarios($id, $tipo)
	{
		$qry ="";
		$qry .= "
		
			SELECT 

				T0.id
				,DATE_FORMAT(T0.fecha, '%d/%m/%Y %H:%i') as fecha 
				,T1.nombre
				,T0.contenido

			FROM Db_Easyclick.Tb_Comentarios T0

			LEFT JOIN Db_Easyclick.Tb_Subscriptores T1 ON T1.id = T0.subscriptor
			
			WHERE T0.origen = ".$id." AND T0.estado = 1 AND T0.tipo = ".$tipo." ORDER BY id desc;		
		";

        return $this->db->query($qry)->result();     
	}
	
	function guardar($subscriptor,$origen,$contenido,$tipo)
	{
		$this->subscriptor = $subscriptor;
		$this->origen = $origen;
		$this->contenido = $contenido;
		$this->estado = 1;
		$this->tipo = $tipo;

        $this->db->insert("Tb_Comentarios",$this);  

		return $this->db->insert_id();
	}
	
	function eliminar($id)
	{
		$this->db->set("estado",0);

        $this->db->where("id",$id);
        
        $this->db->update("Tb_Comentarios"); 
	}
	
	function GetNoValoraciones($tipo,$anuncio)
	{
		$this->db->where("tipo",$tipo);
		$this->db->where("anuncio",$anuncio);
		return $this->db->get("Tb_Stars")->num_rows();
	}
	
	
	
	
	function GetNoEstrellas($tipo,$anuncio)
	{
		$this->db->where("tipo",$tipo);
		$this->db->where("anuncio",$anuncio);
		return $this->db->get("Tb_Stars")->num_rows();
	}
	
	function guardar_valoracion($tipo, $anuncio, $subscriptor, $estrellas)
    {   
		$this->tipo = $tipo;
		$this->subscriptor = $subscriptor;	
		$this->anuncio = $anuncio;
		$this->estrellas = $estrellas;		
		
        $this->db->insert("Tb_Stars",$this);

    }
	
	function actualizar_valoracion($tipo, $anuncio, $subscriptor, $estrellas)
	{
		$this->db->set("estrellas",$estrellas);
        $this->db->where("tipo",$tipo);
		$this->db->where("anuncio",$anuncio);
		$this->db->where("subscriptor",$subscriptor);  
        $this->db->update("Tb_Stars"); 
	}
	
	function validar_valoracion($tipo, $subscriptor, $anuncio)
	{
		$this->db->where("tipo",$tipo);
		$this->db->where("anuncio",$anuncio);
		$this->db->where("subscriptor",$subscriptor);
		return $this->db->get("Tb_Stars")->num_rows();
	}
	
	function obt_valoraciones($tipo, $anuncio)
	{
		$this->db->where("tipo",$tipo);
		$this->db->where("anuncio",$anuncio);
		return $this->db->get("Tb_Stars")->result();
	}
	
	function actualizar_valoracion_empresa($id, $valoracion)
	{
		$this->db->set("valoracion",$valoracion);
        $this->db->where("id",$id);        
        $this->db->update("Tb_Empresas"); 
	}
	
	function actualizar_valoracion_novedad($id, $valoracion)
	{
		$this->db->set("valoracion",$valoracion);
        $this->db->where("id",$id);        
        $this->db->update("Tb_Novedades"); 
	}
	
	
	
	function getNoVistas($tipo, $anuncio)
	{
		$this->db->where("anuncio",$anuncio);
		$this->db->where("tipo",$tipo);		
		return $this->db->get("Tb_Vistas")->num_rows();
	}
	
	function ver($tipo, $anuncio, $subscriptor)
	{
		
		$this->tipo = $tipo;
		$this->anuncio = $anuncio;
		$this->subscriptor = $subscriptor;
		$this->origen = 2;
		
        $this->db->insert("Tb_Vistas",$this);  

		return $this->db->insert_id();
	}
	
	
	
	function getNoComentarios($tipo, $anuncio)
	{
		$this->db->where("anuncio",$anuncio);
		$this->db->where("tipo",$tipo);		
		return $this->db->get("Tb_Comentarios")->num_rows();
	}
	
}
?>
