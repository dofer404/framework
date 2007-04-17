<?php

class toba_info_item implements toba_nodo_arbol 
{
	protected $subelementos = array();
	protected $proyecto;
	protected $id;
	protected $datos;
	protected $nivel;					//Nivel del item en el arbol de items
	protected $grupos_acceso;			//Grupos que pueden acceder al item
	protected $camino;					//Arreglo de carpetas que componen la rama en donde pertenece el item
	protected $items_hijos=array();		//Arreglo de hijos 
	protected $padre=null;				//Objeto item padre
	protected $info_extra = '';
	protected $carga_profundidad;
	
	function __construct( $datos, $carga_profundidad=true)
	{
		$this->datos = $datos;	
		$this->id = $this->datos['basica']['item'];
		$this->proyecto = $this->datos['basica']['item_proyecto'];
		$this->carga_profundidad = $carga_profundidad;
		if ($this->carga_profundidad) {
			$this->cargar_dependencias();
		}
		if($this->es_de_menu()) {
			$this->info_extra .= toba_recurso::imagen_proyecto("menu.gif",true)." - Est� inclu�do en el MENU";
		}
	}

	function cargar_dependencias()
	{
		//Si hay objetos asociados...
		if (isset($this->datos['objetos']) && count($this->datos['objetos'])>0)	{
			for ($a=0; $a<count($this->datos['objetos']); $a++) {
				$clave['proyecto'] = $this->datos['objetos'][$a]['objeto_proyecto'];
				$clave['componente'] = $this->datos['objetos'][$a]['objeto'];
				$tipo = toba_catalogo::convertir_tipo( $this->datos['objetos'][$a]['clase'] );
				$this->subelementos[$a] = toba_constructor::get_info( $clave, $tipo );
			}
		}
	}

	/**
	*	Crea una rama de items comenzando por la raiz
	*	Al asumir que los niveles son pocos se hace una consulta por nivel
	*	Quedan cargado en el objeto los ancestros de la rama
	*/
	function cargar_rama()
	{
		$item_ancestro = $this;
		while (! $item_ancestro->es_raiz()) {
			$id = array('componente' => $item_ancestro->get_id_padre(), 
						'proyecto' => $item_ancestro->get_proyecto());
			$nodo = toba_constructor::get_info($id, 'item', false);
			$item_ancestro->set_padre($nodo);
			$item_ancestro = $nodo;
		}
	}	
	
	//---------------------------------------------------------------------	
	// Preguntas 
	//---------------------------------------------------------------------

	function es_carpeta() 
	{ 
		return $this->datos['basica']['carpeta']; 
	}
	
	function es_de_menu() {	
		if (! $this->es_raiz()) {
			return $this->datos['basica']['menu'];
		} else {
			return true;	
		}
	}
	
	function es_raiz()
	{
		return $this->id == '__raiz__';	
	}
	
	function es_publico() { return $this->datos['basica']['publico']; } 

	function puede_redireccionar() { return $this->datos['basica']['redirecciona']; } 

	function vinculo_editor()
	{
		if ($this->es_carpeta())
			$item_editor = "/admin/items/carpeta_propiedades";
		else
			$item_editor = "/admin/items/editor_items";		
		return toba::vinculador()->generar_solicitud(toba_editor::get_id(), $item_editor,
						array( apex_hilo_qs_zona => $this->proyecto .apex_qs_separador. $this->id),
						false, false, null, true, "central");
	}

	/**
	*	EJECUCION de ITEMS desde el administrador
	*/
	function vinculo_ejecutar()
	{
		if( toba_contexto_info::get_proyecto() == toba_editor::get_id() ) {
			$vinculo = toba::vinculador()->crear_vinculo($this->get_proyecto(), $this->get_id(), 
															null, array('celda_memoria'=>'central',
																		'validar' => false,
																		'menu' => true ) );
		} else {
			$vinculo = "javascript:top.frame_control.editor.ejecutar_item('".$this->get_id()."');";
		}
		return $vinculo;
	}
	
	/**
	 * Recorre el item en profundidad buscando el objeto pasado por parametro
	 * La ejecuci�n de este m�todo es muy costosa ya que hace una query por objeto
	 */	
	function contiene_objeto($id)
	{
		foreach ($this->subelementos as $elem) {
			if ($elem->contiene_objeto($id)) {
				return true;
			}
		}
	}
	
	function get_id_padre() {	return $this->datos['basica']['item_padre']; }	

	function get_nivel_prof() {	return $this->nivel; }
	
	function get_camino() { return $this->camino; }
	
	function get_nombre() { return $this->datos['basica']['item_nombre']; }
	
	function get_proyecto() { return $this->datos['basica']['item_proyecto']; }
	
	function get_tipo_solicitud() { return $this->datos['basica']['solicitud_tipo']; }
	
	function crono() 
	{ 
		if (isset($this->datos['crono']))
			return $this->datos['crono'] == 1; 
	}
	
	function cant_objetos() { return $this->datos['basica']['cant_dependencias']; }
	
	function registra_solicitud()
	{ 
		if (isset($this->datos['basica']['registrar']))
			return $this->datos['basica']["registrar"]; 
	}
	
	function propietario() { return $this->datos['basica']['usuario']; }

	function grupos_acceso()
	{
		if (!isset($this->grupos_acceso)) {
			$sql = "
				SELECT g.usuario_grupo_acc
				FROM
					apex_usuario_grupo_acc_item g
				WHERE
					g.item = '{$this->get_id()}' AND
					g.proyecto = '{$this->get_proyecto()}'
			";
			$rs = toba_contexto_info::get_db()->consultar($sql);
			if (empty($rs))
				$this->grupos_acceso = array();
			else
				$this->grupos_acceso =  aplanar_matriz($rs);
		}
		return $this->grupos_acceso;
	}
		
	function grupo_tiene_permiso($grupo)
	{
		return in_array($grupo, $this->grupos_acceso());
	}
	
	function es_buffer() 
	{ 
		return !($this->datos['basica']['act_buf']== 0 && $this->datos['basica']['act_buf_p']=="toba");
	}
	
	function es_patron()
	//--- Es un PATRON?? El patron <toba,especifico> representa la ausencia de PATRON	
	{
		return !($this->datos['basica']['act_pat']=="especifico" && $this->datos['basica']['act_pat_p']=="toba");
	}
	
	function es_accion()
	{
		return !$this->es_buffer() && !$this->es_patron();
	}

	function es_hijo_de($carpeta)
	{
		if ($this->es_raiz())
			return false;
		return $this->get_id_padre() == $carpeta->get_id();
	}
	
	function es_de_consola()
	{
		return $this->get_tipo_solicitud() == 'consola';	
	}
	
	/**
	 * Un item inaccesible es uno en el que:
	 * 	- Esta marcado por menu pero alguno de sus padres no lo esta
	 * 	- No tiene permisos y no es ni publico ni de consola
	 */	
	function es_inaccesible()
	{
		$grupos = $this->grupos_acceso();
		//--- Si no es de consola ni publico y no tiene grupos de acceso, no hay forma de accederlo
		$sin_grupo = (!$this->es_de_consola() && !$this->es_publico() && count($this->grupos_acceso()) == 0);
		if ($sin_grupo) {
			if (!$this->es_carpeta()) {
				$this->info_extra .= "El �tem es inaccesible porque no hay grupo de acceso que tenga permiso de accederlo.";
			}
			return true;
		}
		//--- Si es de menu y algun padre no lo es, no se va a mostrar en el mismo
		$es_de_menu = $this->es_de_menu();
		$padre = $this->get_padre();
		while ($padre != null) {
			if ($es_de_menu && ! $padre->es_de_menu()) {
				$this->info_extra .= "El �tem es inaccesible por men� porque la carpeta `{$padre->get_nombre()}` no se muestra en el mismo.";
				return true;
				break;
			}
			$padre = $padre->get_padre();
		}
		return false;
	}
	
	//---------------------------------------------------------------------	
	//-- Recorrible como ARBOL
	//---------------------------------------------------------------------
	
	function get_id()
	{
		return $this->id;	
	}
	
	function es_hoja()
	{
		return $this->datos['basica']['cant_items_hijos'] == 0 && $this->cant_objetos() == 0;
	}

	function tiene_propiedades()
	{
		return true;
	}	
	
	function get_nombre_corto()
	{
		return $this->get_nombre();
	}
	
	function get_nombre_largo()
	{
		return $this->get_nombre();
	}
	
	function get_iconos()
	{
		$iconos = array();
		$img_item = null;
		if (isset($this->datos['basica']['item_imagen']) && $this->datos['basica']['item_imagen'] != ''
					&& $this->datos['basica']['item_imagen_recurso_origen'] != '') {
			if ($this->datos['basica']['item_imagen_recurso_origen'] == 'apex') {
				$img_item = toba_recurso::imagen_toba($this->datos['basica']['item_imagen']);	
			} else {
				$img_item = toba_recurso::url_proyecto(toba_editor::get_proyecto_cargado()).'/img/'.
								$this->datos['basica']['item_imagen'];
			}
		}
		if ($this->es_carpeta()) {
			$iconos[] = array(
				'imagen' => isset($img_item) ? $img_item : toba_recurso::imagen_toba("nucleo/carpeta.gif", false),
				'ayuda' => "Carpeta que contiene operaciones.",
				);
		} else {
			$iconos[] = array(
				'imagen' => isset($img_item) ? $img_item : toba_recurso::imagen_proyecto("item.gif", false),
				'ayuda' => "[wiki:Referencia/Item Item] que representa una operaci�n del proyecto.",
				);
				
			if ($this->es_de_consola()) {
				$iconos[] = array(
								'imagen' => toba_recurso::imagen_proyecto("solic_consola.gif",false),
								'ayuda' => 'Solicitud de Consola'
							);
			} elseif($this->get_tipo_solicitud()=="wddx") {
				$iconos[] = array(
								'imagen' => toba_recurso::imagen_proyecto("solic_wddx.gif",false),
								'ayuda' => 'Solicitud WDDX'
							);
			}
			if($this->crono()){		
				$iconos[] = array(
					'imagen' => toba_recurso::imagen_toba("cronometro.gif", false),
					'ayuda'=> "El ITEM se cronometra"
				);			
			}
			if($this->es_publico()){
				$iconos[] = array(
					'imagen' => toba_recurso::imagen_toba("usuarios/usuario.gif", false),
					'ayuda'=> "ITEM p�blico"
				);				
			}
			if($this->puede_redireccionar()){
				$iconos[] = array(
					'imagen' => toba_recurso::imagen_toba("refrescar.png", false),
					'ayuda'=> "ITEM puede redireccionar."
				);				
			}
			if($this->registra_solicitud() == 1){
				$iconos[] = array(
					'imagen' => toba_recurso::imagen_toba("solicitudes.gif", false),
					'ayuda'=> "El ITEM se registra"
				);				
			}
			if ( $this->posee_accion_predefinida() && ! $this->existe_php_accion() ) {
				$iconos[] = array(
					'imagen' => toba_recurso::imagen_toba("nucleo/php_inexistente.gif", false),
					'ayuda'=> "Existe un PHP plano asociado al item, pero el archivo no existe en el path especificado."
				);				
			}
		}
		return $iconos;
	}	
	
	function get_utilerias()
	{
		$utilerias = array();
		
		if ($this->es_carpeta()) {	
			// Ordenamiento, Nueva carpeta, nuevo item
/*			
			$utilerias[] = array(
				'imagen' => toba_recurso::imagen_toba("ordenar.gif", false),
				'ayuda'=> "Ordena alfab�ticamente los items inclu�dos en esta CARPETA",
				'vinculo' => toba::vinculador()->generar_solicitud(toba_editor::get_id(),"/admin/items/carpeta_ordenar", 
								array("padre_p"=>$this->get_proyecto(), "padre_i"=>$this->get_id()) )
			);
*/
			$utilerias[] = array(
				'imagen' => toba_recurso::imagen_toba("nucleo/carpeta_nueva.gif", false),
				'ayuda'=> "Crear SUBCARPETA en esta rama del CATALOGO",
				'vinculo' => toba::vinculador()->generar_solicitud(toba_editor::get_id(),"/admin/items/carpeta_propiedades", 
								array("padre_p"=>$this->get_proyecto(), "padre_i"=>$this->get_id()),false,false,null,true, "central" ),
				'plegado' => true								
			);
			$utilerias[] = array(
				'imagen' => toba_recurso::imagen_proyecto("item_nuevo.gif", false),
				'ayuda'=> "Crear ITEM hijo en esta rama del CATALOGO",
				'vinculo' => toba::vinculador()->generar_solicitud(toba_editor::get_id(),"/admin/items/editor_items", 
								array("padre_p"=>$this->get_proyecto(), "padre_i"=>$this->get_id()),false,false,null,true, "central" ),
				'plegado' => true								
			);			

		} else { //Es un item com�n

			$utilerias[] = array(
				'imagen' => toba_recurso::imagen_toba("objetos/objeto_nuevo.gif", false),
				'ayuda' => "Crear un objeto asociado al item",
				'vinculo' => toba::vinculador()->generar_solicitud(toba_editor::get_id(),"/admin/objetos_toba/crear",
									array('destino_tipo' =>'item', 
											'destino_proyecto' => $this->proyecto,
											'destino_id' => $this->id ),
											false, false, null, true, "central"),
				'plegado' => true											
			);
			
			// Accion!
			if ( $this->posee_accion_predefinida() && $this->existe_php_accion() ) {
				$utilerias[] = $this->get_utileria_editor_abrir_php(array('proyecto'=>$this->proyecto, 'componente' =>$this->id ));
				$utilerias[] = $this->get_utileria_editor_ver_php(array('proyecto'=>$this->proyecto, 'componente' =>$this->id ));
			}			

		}
		if (!$this->es_carpeta() && 
				$this->get_tipo_solicitud() != 'consola' &&
				$this->get_tipo_solicitud() !="wddx") {
			$utilerias[] = array(
							'imagen' => toba_recurso::imagen_toba("instanciar.png",false),
							'ayuda' => 'Ejecutar el ITEM',
							'vinculo' => $this->vinculo_ejecutar()
						);			
			
		}		
			
		$utilerias[] = array(
			'imagen' => toba_recurso::imagen_toba("objetos/editar.gif", false),
			'ayuda' => "Editar propiedades del ITEM",
			'vinculo' => $this->vinculo_editor()
		);				
		return $utilerias;
	}	
	
	function posee_accion_predefinida()
	{
		return ($this->datos['basica']['item_act_accion_script'] != '');
	}
	
	function existe_php_accion()
	{
		if (class_exists('admin_util')) {
			return admin_util::existe_archivo_subclase($this->datos['basica']['item_act_accion_script']);
		} else {
			return false;	
		}
	}

	static function get_utileria_editor_abrir_php($id_componente, $icono='reflexion/abrir.gif')
	{
		$parametros[apex_hilo_qs_zona] = $id_componente['proyecto'] . apex_qs_separador . $id_componente['componente'];
		$opciones = array('servicio' => 'ejecutar', 'zona' => false, 'celda_memoria' => 'ajax', 'menu' => true);
		$vinculo = toba::vinculador()->crear_vinculo(toba_editor::get_id(), "1000058", $parametros, $opciones);
		$js = "toba.comunicar_vinculo('$vinculo')";
		return array(
			'imagen' => toba_recurso::imagen_proyecto($icono, false),
			'ayuda' => 'Abrir el archivo PHP del �tem en el editor del escritorio.' .
					   '<br>Ver [wiki:Referencia/AbrirPhp Configuraci�n]',
			'vinculo' => "javascript: $js;",
			'js' => $js,
			'target' => '',
			'plegado' => false
		);
	}
	
	static function get_utileria_editor_ver_php($id_componente, $icono = 'nucleo/php.gif')
	{
		$parametros[apex_hilo_qs_zona] = $id_componente['proyecto'] . apex_qs_separador . $id_componente['componente'];
		$opciones = array('zona' => true, 'celda_memoria' => 'central', 'menu' => true);
		$vinculo = toba::vinculador()->crear_vinculo(toba_editor::get_id(),"1000058", $parametros, $opciones);
		return array( 'imagen' => toba_recurso::imagen_toba($icono, false),
				'ayuda' => 'Ver el contenido del archivo PHP del �tem',
				'vinculo' => $vinculo,
				'plegado' => true
		);		
	}	

	function agregar_hijo($item)
	{
		$this->items_hijos[$item->get_id()] = $item;
	}
		
	function quitar_hijo($item)
	{
		$this->datos['basica']['cant_items_hijos']--;
		unset($this->items_hijos[$item->get_id()]);
	}	
	
	function set_padre($carpeta)
	{
		$this->padre = $carpeta;
	}

	function get_padre()
	{
		return $this->padre;
	}
	
	function tiene_padre()
	{
		return $this->padre !== null;	
	}

	function get_hijos()
	{
		if ($this->es_carpeta()) {
			return $this->items_hijos;
		} else {
			return $this->subelementos;
		}
	}	
	
	function tiene_hijos_cargados()
	{
		if ($this->es_carpeta() && ! $this->es_hoja()) {
		 	return count($this->items_hijos) == $this->datos['basica']['cant_items_hijos'];
		}
		if (!$this->es_carpeta() && ! $this->carga_profundidad) {
			return false;
		}
		return true;
	}

	function get_info_extra()
	{
		return $this->info_extra;
	}	
	
	function get_zona()
	{
		return $this->datos['basica']['item_zona'];
	}
	//------------------------------------ CAMBIO DE ESTADO --------------------------------------------------------

	function set_nivel($nivel) { $this->nivel = $nivel; }	
	
	function set_camino($camino) {
		$this->camino = $camino;
	}
	
	function otorgar_permiso($grupo)
	{
		$sql = "INSERT INTO apex_usuario_grupo_acc_item (usuario_grupo_acc, proyecto, item) 
				VALUES ('$grupo', '{$this->get_proyecto()}', '{$this->get_id()}')";
		toba_contexto_info::get_db()->ejecutar($sql);
	}

	/**
	 * Duplica un item y sus dependencias recursivamente
	 *
	 * @param array $nuevos_datos Datos a modificar en la base del item. Para anexar algo al nombre se utiliza el campo 'anexo_nombre'
	 * @param boolean/string $dir_subclases Si el componente tiene subclases clona los archivos, en caso afirmativo indicar la ruta destino (relativa)
	 * @param boolean $con_transaccion	Indica si la clonaci�n se debe inclu�r en una transaccion
	 * @return array Clave del item que resulta del clonado
	 */
	function clonar($nuevos_datos, $dir_subclases=false, $con_transaccion=true)
	{
		//-- Cargo el DR asociado
		$id_dr = toba_info_editores::get_dr_de_clase('item');
		$componente = array('proyecto' => $id_dr[0], 'componente' => $id_dr[1]);
		$dr = toba_constructor::get_runtime($componente);
		$dr->inicializar();
		$dr->cargar(array('proyecto' => $this->proyecto, 'item' => $this->id));
		
		foreach ($nuevos_datos as $campo => $valor) {
			if ($campo == 'anexo_nombre') {
				$campo = 'nombre';
				$valor = $valor . $dr->tabla('base')->get_fila_columna(0, $campo);
			}
			if ($campo != 'fuente_datos' && $campo != 'fuente_datos_proyecto') {
				$dr->tabla('base')->set_fila_columna_valor(0, $campo, $valor);
			}
		}
		//Se le fuerza una inserci�n a los datos_tabla
		//Como la clave de los objetos son secuencias, esto garantiza claves nuevas
		$dr->forzar_insercion();
		$dr->get_persistidor()->desactivar_transaccion();
		if ($con_transaccion) {
			abrir_transaccion('instancia');	
		}
		//--- Se clonan los hijos y se agregan como dependencias
		$dr->tabla('objetos')->eliminar_filas();		
		$i=0;		
		foreach ($this->subelementos as $hijo) {
			//-- Si se especifico un proyecto, se propaga
			$datos_objeto = array();
			if (isset($nuevos_datos['proyecto'])) {
				$datos_objeto['proyecto'] = $nuevos_datos['proyecto'];	
			}
			//-- Si se especifica un anexo de nombre, se propaga
			if (isset($nuevos_datos['anexo_nombre'])) {
				$datos_objeto['anexo_nombre'] = $nuevos_datos['anexo_nombre'];
			}
			//-- La fuente tambien se propaga
			if (isset($nuevos_datos['fuente_datos_proyecto'])) {
				$datos_objeto['fuente_datos_proyecto'] = $nuevos_datos['fuente_datos_proyecto'];
			}
			if (isset($nuevos_datos['fuente_datos'])) {
				$datos_objeto['fuente_datos'] = $nuevos_datos['fuente_datos'];
			}
			$nuevo_hijo = $hijo->clonar($datos_objeto, $dir_subclases, false);
			$fila = array('objeto' => $nuevo_hijo['componente'], 
							'proyecto' => $nuevo_hijo['proyecto'], 
							'orden' => $i);			
			$dr->tabla('objetos')->nueva_fila($fila);
			$i++;
		}
		
		//--- GRABA
		$dr->sincronizar();
		if ($con_transaccion) {
			cerrar_transaccion('instancia');	
		}
		
		//Se busca la clave del nuevo objeto
		$clave = $dr->tabla('base')->get_clave_valor(0);
		$clave['componente'] = $clave['item'];
		return $clave;				
	}
	
	function asignar_componente($id_componente)
	{
		$sql = "SELECT COALESCE(MAX(orden),0) as maximo
					FROM apex_item_objeto 
					WHERE item='{$this->id}' AND proyecto='{$this->proyecto}'
			";
		$res = toba_contexto_info::get_db()->consultar($sql);
		$orden = $res[0]['maximo'];
		$sql = "INSERT INTO apex_item_objeto 
					(proyecto, item, objeto, orden) VALUES (
						'{$this->proyecto}', 
						'{$this->id}', 
						'{$id_componente['componente']}', 
						$orden
					)
			";
		toba_contexto_info::get_db()->ejecutar($sql);
	}
	
}
?>