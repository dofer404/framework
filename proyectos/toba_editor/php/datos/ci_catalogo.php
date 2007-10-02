<?php 

class ci_catalogo extends toba_ci
{
	protected $datos_editores;
	
	function ini()
	{
		//Inicializa la lista de editores
		$info_componentes = toba_info_editores::get_info_tipos_componente();
		foreach($info_componentes as $componente) {
			$this->datos_editores[$componente['clase']] = array(	'proyecto' => $componente['editor_proyecto'],
																	'item' => $componente['editor_item']);
		}
	}
	
	function conf()
	{
		
	}
	
	//-----------------------------------------------------------------------------------
	//---- DEPENDENCIAS ------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__fuentes(toba_ei_cuadro $cuadro)
	{
		$datos = toba_info_editores::get_fuentes_datos();
		foreach(array_keys($datos) as $id) {
			$datos[$id]['icono']	= 'fuente.png';
			$img = toba_recurso::imagen_toba("objetos/editar.gif", true, null, null);
			$parametros = array( apex_hilo_qs_zona => $datos[$id]['proyecto'] .apex_qs_separador. $datos[$id]['fuente_datos']);
			$datos[$id]['editar'] = $this->tag_vinculo_editor( 	toba_editor::get_id(),
																'/admin/datos/fuente',
																$parametros,
																$img);
		}
		$cuadro->set_datos($datos);
	}

	function conf__consultas(toba_ei_cuadro $cuadro)
	{
		$datos = toba_info_editores::get_consultas_php();
		foreach(array_keys($datos) as $id) {
			$datos[$id]['icono']	= 'consulta_php.gif';
			$img = toba_recurso::imagen_toba("objetos/editar.gif", true, null, null);
			$parametros = array( apex_hilo_qs_zona => $datos[$id]['proyecto'] .apex_qs_separador. $datos[$id]['consulta_php']);
			$datos[$id]['editar'] = $this->tag_vinculo_editor( 	toba_editor::get_id(),
																'3398',
																$parametros,
																$img);
			if(admin_util::existe_archivo_subclase($datos[$id]['archivo'])) {
				$id_consulta = array($datos[$id]['proyecto'], $datos[$id]['consulta_php']);
				$datos[$id]['editar'] = admin_util::get_acceso_abrir_php( $id_consulta ) . $datos[$id]['editar'];
				$datos[$id]['editar'] = admin_util::get_acceso_ver_php( $id_consulta ). $datos[$id]['editar'];
			}
			$datos[$id]['editar'] = "<div class='editor-lista-vinculos'>" . $datos[$id]['editar'] . "</div>";
		}
		$cuadro->set_datos($datos);
	}
	
	function conf__tablas(toba_ei_cuadro $cuadro)
	{
		$proyecto = toba_contexto_info::get_proyecto();
		$catalogo = new toba_catalogo_objetos($proyecto);
		$objetos = $catalogo->get_objetos(array('clase' => 'toba_datos_tabla'));
		$tablas = toba_info_editores::get_tabla_fuente_de_dt();
		$tablas = rs_convertir_asociativo($tablas, array('id'), 'tabla');
		$datos = array();
		foreach ($objetos as $comp) {
			$tabla = $tablas[$comp->get_id()];
			$datos[$tabla]['editar'] = $this->get_string_iconos($comp->get_utilerias());
			$datos[$tabla]['proyecto'] = $proyecto;
			$datos[$tabla]['fuente'] = $comp->get_fuente_datos();
			$datos[$tabla]['objeto'] = $comp->get_id();
			$datos[$tabla]['tabla'] = $tabla;		
			$datos[$tabla]['icono'] = $this->get_string_iconos($comp->get_iconos());
		}
		//Lo recorre de nuevo para que esten en orden		
		$salida = array();
		foreach ($tablas as $tabla) {
			$salida[] = $datos[$tabla];
		}
		$cuadro->set_datos($salida);
	}

	function conf__arbol_relaciones($componente)
	{
		$componente->set_frame_destino(apex_frame_centro);
		$proyecto = toba_contexto_info::get_proyecto();
		$catalogo = new toba_catalogo_objetos($proyecto);
		$objetos = $catalogo->get_objetos(array('clase' => 'toba_datos_relacion'));
		$componente->set_datos($objetos);
	}

	function evt__arbol_relaciones__cargar_nodo($id)
	{
		$this->dependencia('arbol_relaciones')->set_frame_destino(apex_frame_centro);		
		$proyecto = toba_contexto_info::get_proyecto();
		$catalogo = new toba_catalogo_objetos($proyecto);
		$opciones['id'] = $id;
		$obj = $catalogo->get_objetos($opciones, true);
		return $obj;
	}	

	//---------------------------------------------------------------
	//---------------------------------------------------------------

	function tag_vinculo_editor($item_editor_proyecto, $item_editor, $parametros, $contenido, $ayuda=null)
	{
		$url =  toba::vinculador()->generar_solicitud( 		$item_editor_proyecto, 
															$item_editor,
															$parametros,
															false, false, null, true, 'central');
		$ayuda = isset($ayuda) ? " title=\"".$ayuda."\" " : '';
		return "<a href='".$url."' target='".apex_frame_centro."' ".$ayuda." >".$contenido."</a>\n";
	}

	function get_string_iconos($iconos)
	{
		$salida = '';
		foreach ($iconos as $icono) {
			$ayuda = toba_parser_ayuda::parsear($icono['ayuda']);
			$img = toba_recurso::imagen($icono['imagen'], null, null, $ayuda);
			if (isset($icono['vinculo'])) {
				$salida .= "<a target='".apex_frame_centro."' href=\"".$icono['vinculo']."\">$img</a>\n";
			} else {
				$salida .= $img."\n";
			}
		}
		return $salida;	
	}
}

class pantalla_catalogo extends toba_ei_pantalla 
{
	function generar_layout()
	{
		foreach($this->_dependencias as $dep) {
			$dep->generar_html();	
		}
	}
}

?>