<?
require_once("nucleo/componentes/runtime/objeto.php");
require_once('eventos.php');
define('apex_ei_analisis_fila', 'apex_ei_analisis_fila');   //Id de la columna utilizada para el resultado del analisis de una fila
define("apex_ei_evento","evt");
define("apex_ei_separador","__");
define("apex_db_registros_clave","x_dbr_clave");			//Clave interna de los DB_REGISTROS
define("apex_datos_clave_fila","x_dbr_clave");				//Clave interna de los datos_tabla, por compatibilidad es igual.

/**
 * Clase base de los elementos de interface (ei)
 * @package Objetos
 * @subpackage Ei
 */
class objeto_ei extends objeto
{
	protected $controlador;
	protected $info_eventos;
	protected $colapsado = false;						//El elemento s�lo mantiene su t�tulo
	protected $evento_por_defecto=null;					//Evento disparado cuando no hay una orden explicita
	protected $eventos = array();
	protected $grupo_eventos_activo = '';				// Define el grupo de eventos activos

	function destruir()
	{
		$this->memoria["eventos"] = array();
		if(isset($this->eventos)){
			foreach($this->eventos as $id => $evento ){
				if(isset($evento['maneja_datos'])){
					$val = $evento['maneja_datos'];
				}else{
					$val = true;	
				}
				$this->memoria["eventos"][$id] = $val;
			}
		}
		parent::destruir();
	}	
	
	function inicializar($parametros)
	{
		$this->id_en_padre = $parametros['id'];		
	}

	function cargar_datos(){}

	//--------------------------------------------------------------------
	//--  EVENTOS   ------------------------------------------------------
	//--------------------------------------------------------------------

	protected function disparar_eventos(){}

	public function agregar_controlador($controlador)
	{
		$this->controlador = $controlador;
	}

	protected function reportar_evento($evento)
	//Registro un evento en todos mis controladores
	{
		$parametros = func_get_args();
		$parametros	= array_merge(array($this->id_en_padre), $parametros);
		return call_user_func_array( array($this->controlador, 'registrar_evento'), $parametros);
		//$this->controladores[$id]->registrar_evento( $this->id_en_padre, $evento, $parametros );			
	}

	public function definir_eventos()
	{
		$this->eventos = $this->get_lista_eventos();
		//toba::get_logger()->debug($this->get_txt() . "### EVENTOS UTILIZADOS ###");
		//toba::get_logger()->debug($this->eventos);
	}
		
	public function get_lista_eventos()
	{
		$eventos = $this->get_lista_eventos_definidos();
		$grupo = $this->get_grupo_eventos_activo();
		//Si hay un grupo de eventos definido:
		//	filtro los eventos que:
		// 		* Van a la botonera
		//		* Tienen al menos un grupo definido
		if(trim($grupo)!=''){ 
			foreach(array_keys($eventos) as $id){
				$en_botonera =  (trim($eventos[$id]['en_botonera'])==1);
				$pertenece_a_grupo_actual = false;
				if(trim($eventos[$id]['grupo'])!=''){
					$asociacion_grupos = array_map('trim',explode(',',$eventos[$id]['grupo']));
					$pertenece_a_grupo_actual = in_array($grupo, $asociacion_grupos );
				}else{
					//Los que no tienen grupo definido no hay que filtrarlos
					continue;
				}
				//En un principio esto se usa solo para FILTRAR la botonera
				if( $en_botonera && !($pertenece_a_grupo_actual) ){
					toba::get_logger()->debug("Se filtro el evento: $id");
					unset($eventos[$id]);
				}
			}
		}
		return $eventos;
	}
	
	protected function get_lista_eventos_definidos()
	/*
	*	Obtiene la lista de eventos definidos desde el administrador 
	*/
	{
		$eventos = array();
		foreach ($this->info_eventos as $evento) {
			$eventos[$evento['identificador']] = $evento;
			//Seteo el evento por defecto
			if($evento['implicito']){
				toba::get_logger()->debug($this->get_txt() . " IMPLICITO: " . $evento['identificador']);
				$this->set_evento_defecto($evento['identificador']);
			}
		}
		//toba::get_logger()->debug($this->get_txt() . "--- EVENTOS definidos ---");
		//toba::get_logger()->debug($eventos);
		return $eventos;
	}
	
	function cant_eventos_sobre_fila()
	{
		$cant = 0;
		foreach ($this->eventos as $evento) {
			if ($evento['sobre_fila'])
				$cant++;
		}
		return $cant;
	}
	
	protected function evento_es_en_botonera($evento)
	{
		//Se asume que si no se definio nada en el evento, es en botonera					
		return !isset($evento['en_botonera']) ||  trim($evento['en_botonera'])==1;
	}
	
	function hay_botones() 
	{
		foreach(array_keys($this->eventos) as $id  ) {	
			if ($this->evento_es_en_botonera($this->eventos[$id]) ) {
				return true;
			}
		}
		return false;
	}	
	
	function obtener_botones()
	{
		//----------- Generacion
		echo "<table class='tabla-0' align='center' width='100%'>\n";
		echo "<tr><td align='right'>";
		$this->obtener_botones_eventos();
		echo "</td></tr>\n";
		echo "</table>\n";
	}	
	
	/*
		Genera los botones de todos los eventos marcardos para aparecer en la botonera.
	*/
	function obtener_botones_eventos()
	{
		foreach(array_keys($this->eventos) as $id )	{
			if ($this->evento_es_en_botonera($this->eventos[$id])) {
				$this->generar_boton_evento($id);
			}
		}
	}

	/*
		Genera el HTML del BOTON correspondiente a un evento definido
	*/
	function generar_boton_evento($id)
	{
		if(!isset($this->eventos[$id])){
			throw new excepcion_toba("Se solicito la generacion de un boton sobre un evento inexistente: '$id'");
		}
		$tip = '';
		if (isset($this->eventos[$id]['ayuda']))
			$tip = $this->eventos[$id]['ayuda'];
		$clase = ( isset($this->eventos[$id]['estilo']) && (trim( $this->eventos[$id]['estilo'] ) != "")) ? $this->eventos[$id]['estilo'] : "abm-input";
		$tab_order = 0;//Esto esta MAAL!!!
		$acceso = tecla_acceso( $this->eventos[$id]["etiqueta"] );
		$html = '';
		if (isset($this->eventos[$id]['imagen']) && $this->eventos[$id]['imagen']) {
			if (isset($this->eventos[$id]['imagen_recurso_origen']))
				$img = recurso::imagen_de_origen($this->eventos[$id]['imagen'], $this->eventos[$id]['imagen_recurso_origen']);
			else
				$img = $this->eventos[$id]['imagen'];
			$html = recurso::imagen($img, null, null, null, null, null, 'vertical-align: middle;').' ';
		}
		$html .= $acceso[0];
		$tecla = $acceso[1];
		$evento_js = eventos::a_javascript($id, $this->eventos[$id]);
		$js = "onclick=\"{$this->objeto_js}.set_evento($evento_js);\"";
		echo "&nbsp;" . form::button_html( $this->submit."_".$id, $html, $js, $tab_order, $tecla, $tip, 'button', '', $clase);
	}

	//--- Manejo de grupos de eventos
	
	/**
		Activa un grupo de eventos
	*/
	function set_grupo_eventos_activo($grupo)
	{
		$this->grupo_eventos_activo = $grupo;
	}
	
	/**
		Devuelve el grupo de eventos activos
	*/
	function get_grupo_eventos_activo()
	{
		return $this->grupo_eventos_activo;	
	}
	
	//--------------------------------------------------------------------
	//--  Cosas VIEJAS  --------------------------------------------------
	//--------------------------------------------------------------------


	function agregar_evento($evento, $establecer_como_predeterminado=false)
	{
		asercion::es_array_dimension($evento,1);
		$this->eventos = array_merge($this->eventos, $evento);
		if($establecer_como_predeterminado){
			$id = key($evento);
			$this->set_evento_defecto($id);
		}
		toba::get_logger()->obsoleto("", __FUNCTION__, "0.8.3",'Definir los eventos en el administrador');		
	}

	public function set_eventos($eventos)
	{
		$this->eventos = $eventos;
		toba::get_logger()->obsoleto("", __FUNCTION__, "0.8.3",'Definir los eventos en el administrador');		
	}

	/**
	 * Fuerza que el evento sea implicito en este objeto (no necesita de intervenci�n del usuario para lanzarse)
	 * @param string $id Id. del evento
	 */
	public function set_evento_defecto($id)
	{
		$this->evento_por_defecto = $id;
	}

	//--------------------------------------------------------------------
	//--  INTERFACE GRAFICA   --------------------------------------------
	//--------------------------------------------------------------------

	public function colapsar()
	{
		$this->colapsado = true;
		$this->info['colapsable'] = true;
	}
	
	public function set_colapsable($colapsable)
	{
		$this->info['colapsable'] = $colapsable;
	}
	
	public function consumo_javascript_global()
	{
		return array('clases/objeto');
	}
	
	function obtener_javascript()
	{
		$identado = js::instancia()->identado();
		echo "\n$identado//---------------- CREANDO OBJETO {$this->objeto_js} --------------  \n";
		$this->crear_objeto_js();
		$this->extender_objeto_js();
		echo "\n";
		$this->iniciar_objeto_js();
		echo "$identado//-----------------------------------------------------------------  \n";		
		return $this->objeto_js;
	}
	
	protected function crear_objeto_js()
	{
		$identado = js::instancia()->identado();
		echo $identado."window.{$this->objeto_js} = new objeto('{$this->objeto_js}');\n";
	}
	
	protected function extender_objeto_js()
	{

	}
	
	protected function iniciar_objeto_js()
	{
		$identado = js::instancia()->identado();
		//-- EVENTO por DEFECTO --
		if($this->evento_por_defecto != null && isset($this->eventos[$this->evento_por_defecto])){
			$evento = eventos::a_javascript($this->evento_por_defecto, $this->eventos[$this->evento_por_defecto]);
			echo js::instancia()->identado()."{$this->objeto_js}.set_evento_defecto($evento);\n";
		}
		if ($this->colapsado) {
			echo $identado."window.{$this->objeto_js}.colapsar();\n";
		}
		//Se agrega al objeto al singleton toba
		echo $identado."toba.agregar_objeto(window.{$this->objeto_js});\n";		
	}

	//---------------------------------------------------------------
	//----------------------  SALIDA Impresion  ---------------------
	//---------------------------------------------------------------

	/*
	*	Despachador de tipos de salidas de impresion
	*/
	function vista_impresion( impresion $salida )
	{
		if ( $salida instanceof html_impr ) {
			$this->vista_impresion_html( $salida );	
		}
	}

	/*
	*	Impresion HTML por defecto
	*/
	function vista_impresion_html( $salida )
	{
		$salida->titulo( $this->get_nombre() );
	}

	/**
	*	Devuelve un autovinculo pidiendo un servicio PDF
	*/
	function vinculo_vista_html_impresion()
	{
		$opciones['servicio'] = 'vista_html_impr';
		$opciones['objetos_destino'] = array( $this->id );
		return toba::get_vinculador()->crear_vinculo( null, null, array(), $opciones );
	}
}
?>