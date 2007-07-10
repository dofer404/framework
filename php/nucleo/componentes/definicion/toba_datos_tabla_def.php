<?php

class toba_datos_tabla_def extends toba_componente_def
{
	static function get_estructura()
	{
		$estructura = parent::get_estructura();
		$estructura[] = array( 	'tabla' => 'apex_objeto_db_registros',
								'registros' => '1',
								'obligatorio' => true );
		$estructura[] = array( 	'tabla' => 'apex_objeto_db_registros_col',
								'registros' => 'n',
								'obligatorio' => true );
		$estructura[] = array( 	'tabla' => 'apex_objeto_db_registros_ext',
								'registros' => 'n',
								'obligatorio' => false );
		$estructura[] = array( 	'tabla' => 'apex_objeto_db_registros_ext_col',
								'registros' => 'n',
								'obligatorio' => false );
		$estructura[] = array( 	'tabla' => 'apex_objeto_db_registros_uniq',
								'registros' => 'n',
								'obligatorio' => false );
		return $estructura;		
	}
	
	static function get_vista_extendida($proyecto, $componente=null)
	{
		$sql = parent::get_vista_extendida($proyecto, $componente);
		//------------- Info base de la estructura ----------------
		$sql['_info_estructura']['sql'] = "SELECT	dt.tabla    as tabla,
											dt.alias          	as alias,
											dt.min_registros  	as min_registros,
											dt.max_registros  	as max_registros,
											dt.ap				as ap			,	
											dt.ap_clase			as ap_sub_clase	,	
											dt.ap_archivo	    as ap_sub_clase_archivo,
											dt.modificar_claves as ap_modificar_claves,
											ap.clase			as ap_clase,
											ap.archivo			as ap_clase_archivo
					 FROM		apex_objeto_db_registros as dt
				 				LEFT OUTER JOIN apex_admin_persistencia ap ON dt.ap = ap.ap
					 WHERE		objeto_proyecto='$proyecto' ";
		if ( isset($componente) ) {
			$sql['_info_estructura']['sql'] .= "	AND		objeto='$componente' ";	
		}
		$sql['_info_estructura']['sql'] .= ";";
		$sql['_info_estructura']['registros']='1';
		$sql['_info_estructura']['obligatorio']=true;
		//------------ Columnas ----------------
		$sql['_info_columnas']['sql'] = "SELECT	objeto_proyecto,
						objeto 			,	
						col_id			,	
						columna			,	
						tipo			,	
						pk				,	
						secuencia		,
						largo			,	
						no_nulo			,	
						no_nulo_db		,
						externa
					 FROM		apex_objeto_db_registros_col 
					 WHERE		objeto_proyecto = '$proyecto' ";
		if ( isset($componente) ) {
			$sql['_info_columnas']['sql'] .= "	AND		objeto='$componente' ";	
		}
		$sql['_info_columnas']['sql'] .= ";";
		$sql['_info_columnas']['registros']='n';
		$sql['_info_columnas']['obligatorio']=true;
		
		//------------ Externas ----------------
		$sql['_info_externas']['sql'] = "SELECT	objeto_proyecto,
						objeto 			,	
						externa_id		,	
						tipo			,	
						sincro_continua	,	
						metodo			,
						clase			,	
						include			,	
						sql
					 FROM		apex_objeto_db_registros_ext 
					 WHERE		objeto_proyecto = '$proyecto' ";
		if ( isset($componente) ) {
			$sql['_info_externas']['sql'] .= "	AND		objeto='$componente' ";	
		}
		$sql['_info_externas']['sql'] .= ";";
		$sql['_info_externas']['registros']='n';
		$sql['_info_externas']['obligatorio']=false;
		
		//------------ Externas ----------------
		$sql['_info_externas_col']['sql'] = "SELECT	ext_col.objeto_proyecto,
						ext_col.objeto 			,	
						ext_col.externa_id		,	
						ext_col.es_resultado	,
						col.columna				
					 FROM	
					 		apex_objeto_db_registros_ext_col ext_col,
					 		apex_objeto_db_registros_col col
					 WHERE		
					 		ext_col.objeto_proyecto = '$proyecto' AND
					 		col.objeto_proyecto = '$proyecto' AND
					 		ext_col.col_id = col.col_id	
					 	";
		if ( isset($componente) ) {
			$sql['_info_externas_col']['sql'] .= "	AND		ext_col.objeto='$componente' ";	
		}
		$sql['_info_externas_col']['sql'] .= ";";
		$sql['_info_externas_col']['registros']='n';
		$sql['_info_externas_col']['obligatorio']=false;

		//------------ Valores Unicos ----------------
		$sql['_info_valores_unicos']['sql'] = "SELECT	columnas
					 FROM	apex_objeto_db_registros_uniq
					 WHERE	objeto_proyecto = '$proyecto'";
		if ( isset($componente) ) {
			$sql['_info_valores_unicos']['sql'] .= "	AND		objeto='$componente' ";	
		}
		$sql['_info_valores_unicos']['sql'] .= ";";
		$sql['_info_valores_unicos']['registros']='n';
		$sql['_info_valores_unicos']['obligatorio']=false;
				
		return $sql;
	}

	static function get_vista_extendida_resumida($proyecto, $componente)
	{
		$estructura = self::get_vista_extendida($proyecto, $componente);
		unset($estructura['_info_columnas']);
		unset($estructura['_info_externas']);
		unset($estructura['_info_externas_col']);
		return $estructura;
	}
}
?>