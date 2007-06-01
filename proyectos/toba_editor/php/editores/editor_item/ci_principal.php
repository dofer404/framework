<?php
require_once('seleccion_imagenes.php');

class ci_principal extends toba_ci
{
	protected $s__id_item ;
	protected $s__inicializar_item_nuevo = true;
	protected $id_temporal = "<span style='white-space:nowrap'>A asignar</span>";
	private $elemento_eliminado = false;
	protected $cambio_item = false;
	private $refrescar = false;
	
	
	function ini()
	{
		$zona = toba::zona();
		if ($zona->cargada()) {
			list($proyecto, $item) = $zona->get_editable();
			//Se notifica un item y un proyecto	
			if (isset($item) && isset($proyecto)) {
				//Se determina si es un nuevo item
				$es_nuevo = (!isset($this->s__id_item ) || 
							($this->s__id_item['proyecto'] != $proyecto || $this->s__id_item ['item'] != $item));
				if ($es_nuevo) {
					$this->set_item( array('proyecto'=>$proyecto, 'item'=>$item) );
					$this->cambio_item = true;
				}
			}
		} else {
			//Creacion de un item nuevo
			if ( $this->s__inicializar_item_nuevo ) {
				unset($this->s__id_item );
				$datos = $this->get_entidad();
				$datos->resetear();
				$this->inicializar_item( $datos );
				$this->s__inicializar_item_nuevo = false;
			}
		}
	}
	
	function get_entidad()
	//Acceso al DATOS_RELACION
	{
		if ($this->cambio_item){
			toba::logger()->debug($this->get_txt() . '*** se cargo el item: ' . $this->s__id_item );
			$this->dependencia('datos')->cargar( $this->s__id_item );
		}
		return $this->dependencia('datos');
	}	

	function set_item($id)
	{
		$this->s__id_item  = $id;
	}
	
	function conf()
	{
		if(! $this->get_entidad()->esta_cargada()){
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}	
	
	/**
	*	Inicializacion de un ITEM nuevo, llega el DR vacio
	*/
	function inicializar_item( $dr )
	{
		//Ver si el padre viene por post
		$padre_i = toba::memoria()->get_parametro('padre_i');
		$padre_p = toba::memoria()->get_parametro('padre_p');
		if (isset($padre_p) && isset($padre_i)) {
			$datos = array('item' => $this->id_temporal);
			$datos['padre'] = $padre_i;
			$datos['padre_proyecto'] = $padre_p;

		}
		$dr->tabla('base')->set( $datos );
		//Le agrego el permiso del usuario actual
		foreach( toba::usuario()->get_grupos_acceso() as $grupo) {
			$permiso_usuario_actual = array('usuario_grupo_acc' => $grupo );
			$dr->tabla('permisos')->nueva_fila( $permiso_usuario_actual );
		}
	}

	//-------------------------------------------------------------------
	//--- PROPIEDADES BASICAS
	//-------------------------------------------------------------------

	function conf__prop_basicas()
	{
		$datos = $this->get_entidad()->tabla("base")->get();
	
		//Transfiere los campos accion, buffer y patron a uno comportamiento
		if (isset($datos['actividad_accion']) && $datos['actividad_accion'] != '') {
			$datos['comportamiento'] = 'accion';
		}
		if (isset($datos['actividad_buffer']) && $datos['actividad_buffer'] != 0) {
			$datos['comportamiento'] = 'buffer';
		}
		if (isset($datos['actividad_patron']) && $datos['actividad_patron'] != 'especifico') {
			$datos['comportamiento'] = 'patron';
		}
		return $datos;
	}

	function evt__prop_basicas__modificacion($registro)
	{
		//El campo comportamiento incide en el buffer, patron y accion
		if ($registro['solicitud_tipo'] == 'browser') {		
			switch ($registro['comportamiento']) {
				case 'accion':
					$registro['actividad_buffer'] = 0;
					$registro['actividad_patron'] = 'especifico';
					break;
				case 'buffer':
					$registro['actividad_accion'] = '';
					$registro['actividad_patron'] = 'especifico';				
					break;
				case 'patron':
					$registro['actividad_buffer'] = 0;
					$registro['actividad_accion'] = '';
					break;								
			}
		}
		unset($registro['comportamiento']);
		$this->get_entidad()->tabla("base")->set($registro);
	}
	
	//----------------------------------------------------------
	//-- OBJETOS -----------------------------------------------
	//----------------------------------------------------------
	function conf__objetos()
	{
		$objetos = $this->get_entidad()->tabla('objetos')->get_filas(null, true);
		//Si no hay objetos tratar de inducir las clases dependientes del patron
		if (count($objetos) == 0) {
 			$basicas =$this->get_entidad()->tabla("base")->get();
 			//Es patron?
 			if (isset($basicas['actividad_patron']) && $basicas['actividad_patron'] != 'especifico') {
 				//Este es el lugar para cargar los objetos del tipo deseado
				//$objetos[] = array('clase' => 'toba,toba_ci', apex_ei_analisis_fila => 'A');
 			}
			
		}
		return $objetos;
	}
	
	function evt__objetos__modificacion($objetos)
	{
		$this->get_entidad()->tabla('objetos')->procesar_filas($objetos);
	}
	
	//----------------------------------------------------------
	//-- PERMISOS -------------------------------------------------
	//----------------------------------------------------------
	
	/*
	*	Toma los permisos actuales, les agrega los grupos faltantes y les pone descripcion
	*/
	function conf__permisos()
	{
		$asignados = $this->get_entidad()->tabla('permisos')->get_filas();
		if (!$asignados)
			$asignados = array();
		$grupos = toba_info_permisos::get_grupos_acceso(toba_editor::get_proyecto_cargado());
		$datos = array();
		foreach ($grupos as $grupo) {
			//El grupo esta asignado al item?
			$esta_asignado = false;	
			foreach ($asignados as $asignado) {
				//Si esta asignado ponerle el nombre del grupo y chequear el checkbox
				if ($asignado['usuario_grupo_acc'] == $grupo['usuario_grupo_acc']) {
					$grupo['tiene_permiso'] = 1;
					$grupo['item'] = $this->s__id_item ['item'];
					$esta_asignado = true;
				}
			}
			//Si no esta asignado poner el item y deschequear el checkbox
			if (!$esta_asignado) {
				$grupo['tiene_permiso'] = 0;
				$grupo['item'] = $this->s__id_item ['item'];
			}
			$datos[] = $grupo;
		}
		return $datos;
	}
	
	function evt__permisos__modificacion($grupos)
	{
		$dbr = $this->get_entidad()->tabla('permisos');
		$asignados = $dbr->get_filas(array(), true);
		if (!$asignados)
			$asignados = array();		
//		ei_arbol($asignados, 'asignados');
//		ei_arbol($grupos, 'nuevos');
		foreach ($grupos as $grupo)
		{
			$estaba_asignado = false;
			foreach ($asignados as $id => $asignado) {
				//�Estaba asignado anteriormente?
				if ($asignado['usuario_grupo_acc'] == $grupo['usuario_grupo_acc']) {
					$estaba_asignado = true;
					if (! $grupo['tiene_permiso']) {
						//Si estaba asignado, y fue deseleccionado entonces borrar
						$dbr->eliminar_fila($id);
					}
				}
			}
			//Si no estaba asignado y ahora se asigna, agregarlo
			if (!$estaba_asignado && $grupo['tiene_permiso']) {
				unset($grupo['tiene_permiso']);
				unset($grupo['nombre']);
				$dbr->nueva_fila($grupo);
			}
		}
	}
	
	// *******************************************************************
	// *******************  PROCESAMIENTO  *******************************
	// *******************************************************************

	function evt__procesar()
	{
		//Seteo los datos asociados al uso de este editor
		$this->get_entidad()->tabla('base')->set_fila_columna_valor(0,"proyecto",toba_editor::get_proyecto_cargado() );
		//Sincronizo el DBT
		$this->get_entidad()->sincronizar();	
		if (! isset($this->s__id_item )) {		//Si el item es nuevo
			$datos = $this->get_entidad()->tabla("base")->get();
			admin_util::refrescar_editor_item( $datos['item'] );						
			admin_util::redirecionar_a_editor_item( $datos['proyecto'], $datos['item']);			
		}
	}

	function evt__eliminar()
	{
		$this->get_entidad()->eliminar();
		toba::notificacion()->agregar("El item ha sido eliminado","info");
		toba::zona()->resetear();
		admin_util::refrescar_editor_item();
	}
	

	/**
	 * Servicio para mostrar la imagen
	 */
	function servicio__ejecutar()
	{
		seleccion_imagenes::generar_html_listado();
	}
}

?>
