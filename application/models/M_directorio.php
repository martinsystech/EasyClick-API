<?php

class M_directorio extends CI_Model {
	
    function __construct()
    {
        parent::__construct();
    }
	 
	
	function obt_anuncios($giro)
	{
		$this->db->where("giro",$giro);	

		$this->db->order_by("aniversario","desc");
		
		return $this->db->get("Tb_Empresas")->result();
	}
	
	function obt_anuncio($id)
	{
		$qry ="";
		$qry .= "
		
			SELECT

				T0.id
				,T0.nombre
				,T0.eslogan
				,T0.telefono
				,T0.correo
				,T0.web
				,T0.facebook
				,T0.twitter
				,T0.pinterest
				,T0.valoracion
				,T0.latitud
				,T0.longitud
				,T0.nosotros
				,CONCAT(IFNULL(T0.calle,''),' ',IFNULL(T0.numero,''),' ',IFNULL(T0.colonia,''),' ',IFNULL(T0.cp,'')) as direccion
				,T1.nombre as estado
				,T2.nombre as municipio
				,T3.opcion as giro
				,T4.opcion as categoria
				
			FROM Db_Easyclick.Tb_Empresas T0

			LEFT JOIN Db_Easyclick.Tb_CatEstado T1 ON T1.id = T0.estado
			LEFT JOIN Db_Easyclick.Tb_CatMunicipios T2 ON 	T2.id = T0.municipio
			LEFT JOIN Db_Easyclick.Tb_CatGiros T3 ON T3.id = T0.giro
			LEFT JOIN Db_Easyclick.Tb_CatCategorias T4 ON T4.id = T0.categoria

			WHERE T0.activo = 2 AND T0.id = ".$id.";";
			
		return $this->db->query($qry)->row();     
	}
	
	function obtImagenComplemento($id)
    {
		$this->db->where("cliente",$id);	
		$this->db->where("estado",1);	
		$this->db->limit(5);
		$this->db->order_by("id","desc");		
		return $this->db->get("Tb_ImagenesComplemento")->result();    
    }
	
	
	function GetAnuncios($giro , $categoria, $estado, $municipio, $busqueda)
	{
		$qry ="";
		$qry .= "
		
			SELECT

				T0.id
				,T0.nombre 
				,T0.eslogan
				,T0.valoracion
				,CONCAT(IFNULL(T0.calle,''),' ',IFNULL(T0.numero,''),' ',IFNULL(T0.colonia,''),' ',IFNULL(T0.cp,'')) as direccion
				,T1.nombre as estado
				,T2.nombre as municipio
				,T3.opcion as giro
				,T4.opcion as categoria
				
			FROM Db_Easyclick.Tb_Empresas T0

			LEFT JOIN Db_Easyclick.Tb_CatEstado T1 ON T1.id = T0.estado
			LEFT JOIN Db_Easyclick.Tb_CatMunicipios T2 ON T2.id = T0.municipio
			LEFT JOIN Db_Easyclick.Tb_CatGiros T3 ON T3.id = T0.giro
			LEFT JOIN Db_Easyclick.Tb_CatCategorias T4 ON T4.id = T0.categoria


			WHERE activo = 2 ";
			
			
			if($giro != '' && $giro != '0' && $giro != null && $giro != "null")
			{
				$qry .= " AND T0.giro = ".$giro;
			}
			if($categoria != '' && $categoria != '0' && $categoria != null && $categoria != "null")
			{
				$qry .= " AND T0.categoria = ".$categoria;
			}
			
			if($estado != '' && $estado != '0' && $estado != null && $estado != "null")
			{
				$qry .= " AND T0.estado = ".$estado;
			}
			
			if($municipio != '' && $municipio != '0' && $municipio != null && $municipio != "null")
			{
				$qry .= " AND T0.municipio = ".$municipio;
			}
			
			if($busqueda != '' && $busqueda != '0' && $busqueda != null && $busqueda != "null")
			{
				$qry .= " AND  (T0.nombre LIKE '%".$busqueda."%' OR T0.eslogan LIKE '%".$busqueda."%')";
			}
			
			
			$qry .= " ORDER BY T0.id DESC;";
			
			return $this->db->query($qry)->result();     
		
		
	}
	
	function GetNovedades($tipo, $giro , $categoria, $estado, $municipio, $busqueda)
	{
		$qry ="";
		$qry .= "
		
			SELECT

				T0.id
				,T0.tipo as idtipo
				,T2.nombre as tipo
				,T0.empresa as idempresa
				,T1.nombre as empresa
				,DATE_FORMAT(T0.termino, '%d/%m/%Y') as fecha 
				,T0.titulo
				,T0.valoracion
				,T0.contenido
				,T3.nombre as estado
				,T4.nombre as municipio
				
			FROM Db_Easyclick.Tb_Novedades T0

			LEFT JOIN Db_Easyclick.Tb_Empresas T1 ON T1.id = T0.empresa
			LEFT JOIN Db_Easyclick.Tb_CatTipoNovedad T2 ON T2.id = T0.tipo
			LEFT JOIN Db_Easyclick.Tb_CatEstado T3 ON T3.id = T1.estado
			LEFT JOIN Db_Easyclick.Tb_CatMunicipios T4 ON T4.id = T1.municipio

			WHERE T0.activo = 2 ";
			
			$qry .= " AND T0.tipo = ".$tipo;
			
			if($giro != '' && $giro != '0' && $giro != null && $giro != "null")
			{
				$qry .= " AND T1.giro = ".$giro;
			}
			if($categoria != '' && $categoria != '0' && $categoria != null && $categoria != "null")
			{
				$qry .= " AND T1.categoria = ".$categoria;
			}
			
			if($estado != '' && $estado != '0' && $estado != null && $estado != "null")
			{
				$qry .= " AND T1.estado = ".$estado;
			}
			
			if($municipio != '' && $municipio != '0' && $municipio != null && $municipio != "null")
			{
				$qry .= " AND T1.municipio = ".$municipio;
			}
			
			if($busqueda != '' && $busqueda != '0' && $busqueda != null && $busqueda != "null")
			{
				$qry .= " AND  (T1.nombre LIKE '%".$busqueda."%' OR T1.eslogan LIKE '%".$busqueda."%' OR T0.titulo LIKE '%".$busqueda."%')";
			}
			$qry .= " ORDER BY T0.id DESC;";
			
			return $this->db->query($qry)->result();     
	}
	
	function GetAnunciosInicio($estado, $municipio)
	{
		$qry ="";
		$qry .= "
		
			SELECT 

				T0.id
				,T0.nombre
				,T0.eslogan
				,T0.valoracion
				,T3.nombre as estado
				,T4.nombre as municipio

			FROM Db_Easyclick.Tb_Empresas T0

			LEFT JOIN Db_Easyclick.Tb_CatGiros T1 ON T1.id = T0.giro
			LEFT JOIN Db_Easyclick.Tb_CatCategorias T2 ON T2.id = T0.categoria
			LEFT JOIN Db_Easyclick.Tb_CatEstado T3 ON T3.id = T0.estado
			LEFT JOIN Db_Easyclick.Tb_CatMunicipios T4 ON T4.id = T0.municipio

			WHERE T0.activo = 2 ";
			
			if($estado != '' && $estado != '0' && $estado != null && $estado != "null")
			{
				$qry .= " AND T0.estado = ".$estado;
			}
			
			if($municipio != '' && $municipio != '0' && $municipio != null && $municipio != "null")
			{
				$qry .= " AND T0.municipio = ".$municipio;
			}
			
			$qry .= " ORDER BY T0.id DESC LIMIT 10;";
			
			return $this->db->query($qry)->result();     
	}
	
	function GetNovedadesInicio($tipo, $estado, $municipio)
	{
		$qry ="";
		$qry .= "
		
			SELECT

				T0.id
				,T0.tipo as idtipo
				,T2.nombre as tipo
				,T0.empresa as idempresa
				,T1.nombre as empresa
				,T0.valoracion
				,DATE_FORMAT(T0.termino, '%d/%m/%Y') as fecha 
				,T0.titulo
				,T3.nombre as estado
				,T4.nombre as municipio
				
			FROM Db_Easyclick.Tb_Novedades T0

			LEFT JOIN Db_Easyclick.Tb_Empresas T1 ON T1.id = T0.empresa
			LEFT JOIN Db_Easyclick.Tb_CatTipoNovedad T2 ON T2.id = T0.tipo
			LEFT JOIN Db_Easyclick.Tb_CatEstado T3 ON T3.id = T1.estado
			LEFT JOIN Db_Easyclick.Tb_CatMunicipios T4 ON T4.id = T1.municipio

			WHERE T0.activo = 2 ";
			
			$qry .= " AND T0.tipo = ".$tipo;
			
			if($estado != '' && $estado != '0' && $estado != null && $estado != "null")
			{
				$qry .= " AND T1.estado = ".$estado;
			}
			
			if($municipio != '' && $municipio != '0' && $municipio != null && $municipio != "null")
			{
				$qry .= " AND T1.municipio = ".$municipio;
			}
			
			$qry .= " ORDER BY T0.id DESC LIMIT 10;";
			
			return $this->db->query($qry)->result();     
	}
}
?>














