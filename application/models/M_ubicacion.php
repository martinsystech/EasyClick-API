<?php

class M_ubicacion extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }

	function obt_estados()
	{
		$this->db->order_by("nombre","asc");	
		return $this->db->get("Tb_CatEstado")->result();
	}
	
	function obt_municipios($id)
	{
		$this->db->where("estado",$id);	
		$this->db->order_by("nombre","asc");	
		return $this->db->get("Tb_CatMunicipios")->result();
	}
	
	function obt_giros()
	{
		$this->db->order_by("opcion","asc");	
		return $this->db->get("Tb_CatGiros")->result();
	} 
	
	function obt_categorias($id)
	{
		$this->db->where("relacion",$id);	
		$this->db->order_by("opcion","asc");	
		return $this->db->get("Tb_CatCategorias")->result();
	}
	
}
?>
