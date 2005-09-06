<?php
require_once('nucleo/browser/clases/objeto_ci.php'); 
require_once('admin/db/dao_editores.php');
//----------------------------------------------------------------

class ci_principal extends objeto_ci
{
	protected $cambio_item;
	protected $id_item;
	
	function __construct($id)
	{
		parent::__construct($id);
		//Cargo el editable de la zona		
		$zona = toba::get_solicitud()->zona();
		if ($editable = $zona->obtener_editable_propagado()){
			$zona->cargar_editable(); 
			list($proyecto, $item) = $editable;
		}	
		//Se notifica un item y un proyecto	
		if (isset($item) && isset($proyecto)) {
			//Se determina si es un nuevo item
			$es_nuevo = (!isset($this->id_item) || 
						($this->id_item['proyecto'] != $proyecto || $this->id_item['item'] != $item));
			if ($es_nuevo) {
				$this->set_item( array('proyecto'=>$proyecto, 'item'=>$item) );
				$this->cambio_item = true;
			}
		}
	}
	
	function mantener_estado_sesion()
	{
		$propiedades = parent::mantener_estado_sesion();
		$propiedades[] = "id_item";
		return $propiedades;
	}	

	function get_entidad()
	//Acceso al DATOS_RELACION
	{
		if (! isset($this->dependencias['datos'])) {
			$this->cargar_dependencia('datos');
		}
		if ($this->cambio_item){
			$this->dependencias['datos']->cargar( $this->id_item );
		}
		return $this->dependencias['datos'];
	}	

	function set_item($id)
	{
		$this->id_item = $id;
	}
	
	function generar_interface_grafica()
	{
		$zona = toba::get_solicitud()->zona();
		if (isset($this->id_item)) {
			$zona->obtener_html_barra_superior();
		}
		parent::generar_interface_grafica();
		if (isset($this->id_item)) {		
			$zona->obtener_html_barra_inferior();
		}
	}	
	
	//-------------------------------------------------------------------
	//--- PROPIEDADES BASICAS
	//-------------------------------------------------------------------

	function evt__prop_basicas__carga()
	{
		//Ver si el padre viene por post
		$padre_i = toba::get_hilo()->obtener_parametro('padre_i');
		$padre_p = toba::get_hilo()->obtener_parametro('padre_p');

		//¿Es un item nuevo?
		if (isset($padre_p) && isset($padre_i)) {
			//Se resetea el dbt para que no recuerde datos anteriores
			unset($this->id_item);
			$this->get_entidad()->resetear();
			//Para el caso del alta el id es asignado automáticamente 
			$datos = array('item' => "<span style='white-space:nowrap'>A asignar</span>");
			$datos['padre'] = $padre_i;
			$datos['padre_proyecto'] = $padre_p;

		} else {
			$datos = $this->get_entidad()->tabla("base")->get();
		}
	
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
		switch ($registro['comportamiento'])
		{
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
		unset($registro['comportamiento']);
		$this->get_entidad()->tabla("base")->set($registro);
	}
	
	//----------------------------------------------------------
	//-- OBJETOS -----------------------------------------------
	//----------------------------------------------------------
	function evt__objetos__carga()
	{
		$objetos = $this->get_entidad()->tabla('objetos')->get_filas();
		return $objetos;
	}
	
	function evt__objetos__modificacion($objetos)
	{
		ei_arbol($objetos);
	}
	
	//----------------------------------------------------------
	//-- PERMISOS -------------------------------------------------
	//----------------------------------------------------------
	
	/*
	*	Toma los permisos actuales, les agrega los grupos faltantes y les pone descripcion
	*/
	function evt__permisos__carga()
	{
		$proyecto = toba::get_hilo()->obtener_proyecto();
		$asignados = $this->get_entidad()->tabla('permisos')->get_filas();
		if (!$asignados)
			$asignados = array();
		$grupos = dao_editores::get_grupos_acceso(toba::get_hilo()->obtener_proyecto());
		$datos = array();
		foreach ($grupos as $grupo) {
			//El grupo esta asignado al item?
			$esta_asignado = false;	
			foreach ($asignados as $asignado) {
				//Si esta asignado ponerle el nombre del grupo y chequear el checkbox
				if ($asignado['usuario_grupo_acc'] == $grupo['usuario_grupo_acc']) {
					$grupo['tiene_permiso'] = 1;
					$grupo['item'] = $this->id_item['item'];
					$esta_asignado = true;
				}
			}
			//Si no esta asignado poner el item y deschequear el checkbox
			if (!$esta_asignado) {
				$grupo['tiene_permiso'] = 0;
				$grupo['item'] = $this->id_item['item'];
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
				//¿Estaba asignado anteriormente?
				if ($asignado['usuario_grupo_acc'] == $grupo['usuario_grupo_acc']) {
					$estaba_asignado = true;
					if (! $grupo['tiene_permiso']) {
						//Si estaba asignado, y fue deseleccionado entonces borrar
						$dbr->eliminar_registro($id);
					}
				}
			}
			//Si no estaba asignado y ahora se asigna, agregarlo
			if (!$estaba_asignado && $grupo['tiene_permiso']) {
				unset($grupo['tiene_permiso']);
				unset($grupo['nombre']);
				$dbr->agregar_registro($grupo);
			}
		}
	}
	
	// *******************************************************************
	// *******************  PROCESAMIENTO  *******************************
	// *******************************************************************
	
	function evt__procesar()
	{
		//Seteo los datos asociados al uso de este editor
		$this->get_entidad()->tabla('base')->set_registro_valor(0,"proyecto",toba::get_hilo()->obtener_proyecto() );
		//Sincronizo el DBT
		$this->get_entidad()->sincronizar();		
	}

	function evt__eliminar()
	{
		$this->get_entidad()->eliminar();
	}
	// *******************************************************************	


}

?>
