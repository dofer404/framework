<?
//Tama�o de la pila de la memoria sincronizada
define("apex_hilo_tamano","5");
//Tipos de reciclado de la memoria global
define('apex_hilo_reciclado_item',0);
define('apex_hilo_reciclado_acceso',1);

//----------------------------------------------------------------
//-------------------- QUERYSTRING Basico ------------------------
//----------------------------------------------------------------
/*
	ATENCION, estas claves compiten con posibles claves de los proyectos consumidores
*/
//Separador en el caso de que una clave transporte varios valores
define("apex_qs_separador","||");			//Separador utilizado para diferenciar campos de valores compuestos
define("apex_qs_sep_interno","^^");			//Separador utilizado para segundo nivel de campos compuestos
// Claves de querystring utilizadas por la pareja VINCULADOR - HILO
define("apex_hilo_qs_id","ah");									//ID de Hilo referenciado
define("apex_hilo_qs_item","ai");								//ITEM de catalogo a solicitar
define("apex_hilo_qs_parametros","ap");							//zona en la que se va a cargar al ITEM
//-- Internos
define("apex_hilo_qs_canal_obj","toba-can");					//Prefijo de los CANALES de OBJETOS (Para comunicarse con ellos por GET)
define("apex_hilo_qs_zona","toba-zona");						//CANAL de propagacion de ZONAS
define("apex_hilo_qs_cronometro","toba-cron");					//CANAL gatillo del cronometro
define("apex_hilo_qs_menu","toma-menu");						//Indica que el vinculo proviene del MENU
define("apex_hilo_qs_celda_memoria","toba-celda-memoria");		//Indicador que indica que el vinculo proviene del MENU
define("apex_hilo_qs_servicio", "toba-servicio");
define("apex_hilo_qs_servicio_defecto", "generar_html");
define("apex_hilo_qs_objetos_destino", "toba-dest");


/**
 * El hilo contiene la informaci�n historica de la aplicaci�n:
 *  - Memoria general de la aplicaci�n (el $_SESSION sin manejo)
 *  - Memoria de las operaciones 
 *  - Memoria sincronizada entre URLs
 *  - Parametros del link desde donde se vino ($_GET)
 */
class toba_hilo
{
	private $id;
	private $url_actual;
	private $item_solicitado;
	private $hilo_referencia;
	private $parametros;
	private $reciclar_memoria = true;	//Habilita el reciclado de la memoria en la sesion
	private $celda_memoria_actual = "central";
	private $acceso_menu;
	private $servicio = apex_hilo_qs_servicio_defecto;
	private $objetos_destino = null;
	static private $instancia;
	
	static function instancia()
	{
		if (!isset(self::$instancia)) {
			self::$instancia = new toba_hilo();
		}
		return self::$instancia;		
	}
	
	private function __construct()
	{
		//dump_session();
		$this->id = uniqid('');
		$this->url_actual = $_SERVER["PHP_SELF"];
        //-[1]- Busco el ID de referencia de la instanciacion anterior del HILO
		//		Este ID me permite ubicar la memoria correcta para el request ACTUAL
		if(isset($_GET[apex_hilo_qs_id])){
			$this->hilo_referencia=$_GET[apex_hilo_qs_id];
		}else{
            //Atencion, no hay hilo de referencia. CONTROLAR!!
            //Esto tiene sentido solo para la pagina de logon (?) para el resto 
            //del sistema implica que las cosas funcionen mal!
        }
		//-[2]- Que ITEM se solicito?
		if(isset($_GET[apex_hilo_qs_item])){
			$item = explode(apex_qs_separador,$_GET[apex_hilo_qs_item]);
            if(count($item)==0){
				$this->item_solicitado = null;
			}elseif(count($item)==2){
				//Dos parametros es OK!
				$this->item_solicitado = $item;
			}else{
				$this->item_solicitado = null;
			}
		}else{
            $this->item_solicitado = null;//No hay parametro
        }
		//-[3]- Recupero los parametros
		$this->parametros = array();
		foreach (array_keys($_GET) as $clave) {
			$this->parametros[utf8_decode($clave)] = utf8_decode($_GET[$clave]);
		}
//		$this->parametros = $_GET;
		//FALTA hacer un URL decode!!!		
		$encriptar_qs = toba::proyecto()->get_parametro('encriptar_qs');
		if($encriptar_qs){
			if(isset($_GET[apex_hilo_qs_parametros])){
				$encriptador = toba::encriptador();
				parse_str($encriptador->descifrar($_GET[apex_hilo_qs_parametros]), $parametros);
				$this->parametros = array_merge($this->parametros, $parametros);
				unset($this->parametros[apex_hilo_qs_parametros]);
				unset($this->parametros["jmb76"]);//Clave agregada para complicar la encriptacion
			}
		}
		unset($this->parametros[apex_hilo_qs_id]);
		unset($this->parametros[apex_hilo_qs_item]);
		
		
		//MEMORIA: Averiguo cual es la CELDA de memoria activa para este REQUEST
		if(isset($this->parametros[apex_hilo_qs_celda_memoria])){
			$this->celda_memoria_actual = $this->parametros[apex_hilo_qs_celda_memoria];
			unset($this->parametros[apex_hilo_qs_celda_memoria]);
			if($this->celda_memoria_actual == 'toba'){
				throw new toba_error_def("No puede utilizarse la palabra 'toba' como nombre de celda");
			}
		}
		if (isset($this->parametros[apex_hilo_qs_servicio])) {
			$this->servicio = $this->parametros[apex_hilo_qs_servicio];
			unset($this->parametros[apex_hilo_qs_servicio]);
		}
		if (isset($this->parametros[apex_hilo_qs_objetos_destino])) {
			$objetos = $this->parametros[apex_hilo_qs_objetos_destino];
			$lista_obj = explode(",", $objetos);
			$this->objetos_destino = array();
			foreach ($lista_obj as $obj) {
				if (trim($obj) != '') {
					$this->objetos_destino[] = explode(apex_qs_separador, $obj);
				}
			}
			unset($this->parametros[apex_hilo_qs_servicio]);
		}		
		//Guardo el FLAG que indica si se accedio por el menu
		if (isset($_GET[apex_hilo_qs_menu])) {
			$this->acceso_menu = true;
		} else {
			$this->acceso_menu = false;
		}

		$this->inicializar_memoria();
 	}

	function destruir()
	{
		//Disparo el proceso de reciclaje
		if($this->reciclar_memoria){
			$this->reciclar_datos_globales_acceso();	
			$this->reciclar_datos_sincronizados();
		}
		//Mantengo guardado cual es el item anterior de la celda
		$celda = $this->get_celda_memoria_actual();
		$_SESSION[$celda]['item_anterior'] = $_SESSION[$celda]['item'];
	}

	function set_item_solicitado( $item ) 
	{
		$this->item_solicitado = $item;
	}

	/**
	 * Muestra el estado actual del hilo
	 */
	function info()
	{
		$dump["item_solicitado"]=$this->item_solicitado;
		$dump["hilo_referencia"]=$this->hilo_referencia;
		$dump["parametros"]=$this->parametros;
		ei_arbol($dump,"HILO");
	}

	/**
	 * Genera la primera porcion de todas las URLs
	 */
	function prefijo_vinculo()
	{
		return $this->url_actual . "?" . apex_hilo_qs_id  . "=" . $this->id;
	}

	/**
	 * Retorna el id que identifica univocamente este request
	 */
	function get_id()
	{
		return $this->id;
	}

	//----------------------------------------------------------------
	//-----------------  ACCESO al ESTADO GENERAL  -------------------
	//----------------------------------------------------------------
	
	/**
	 * Determina si la sesion fue abierta o a�n no se ha logueado el usuario
	 */
	function sesion_abierta()
	{
		return isset($_SESSION['toba']);
	}
	
	/**
	 * Retorna el servicio solicitado por la URL
	 */
	function get_servicio_solicitado()
	{
		return $this->servicio;	
	}
	
	/**
	 * Retorna la referencia a aquellos objetos destino del servicio solicitado
	 */
	function get_id_objetos_destino()
	{
		return $this->objetos_destino;
	}

	/**
	 * Retorna el valor de un par�metro enviado en la URL por el vinculador
	 *
	 * @param string $canal Identificador que se utiliz� como clave del par�metro
	 * @return string Valor pasado como par�metro, o null en el caso que no se encuentre
	 */
	function get_parametro($canal)
	{
		if(isset($this->parametros[$canal])){
			return $this->parametros[$canal];			
		}else{
			return null;
		}
	}

	/**
	 * Retorna todos los par�metros enviados en la URL por el vinculador
	 * @return array Arreglo clave => valor de los par�metros
	 */
	function get_parametros()
	{
		$temp = $this->parametros;
		unset($temp[apex_hilo_qs_zona]);
		return $temp;			
	}

	/**
	 * Retorna el item requerido en este pedido de p�gina
	 * @return array [0]=>proyecto, [1]=>id_item
	 */
	function get_item_solicitado()
	{
		if (isset($this->item_solicitado)) {
			return $this->item_solicitado;
		}
	}

	/**
	 * @deprecated Usar 
	 */
	function get_proyecto()
	{
		return toba::proyecto()->get_id();
	}

	function get_proyecto_descripcion()
	{
		return toba::proyecto()->get_parametro('descripcion');
	}
	
	function get_path()
/*
 	@@acceso: actividad
	@@desc: Devuelve el PATH del toba
*/
	{
		return $_SESSION['toba']["path"];
	}
	
	function get_proyecto_path()
/*
 	@@acceso: actividad
	@@desc: Devuelve el PATH del PROYECTO
*/
	{
			return $_SESSION['toba']["path_proyecto"];
	}
	
	/**
	 * Retorna path real y URL de la carpeta navegable del proyecto actual
	 * @return array Path 'real' (en el sist.arch.) y 'browser' (URL navegable)
	 */
	function get_proyecto_path_www($archivo="")
	{
		$path_real = $this->get_path();
		$path_real = $path_real . "/www/" . $archivo;
		$path_browser = toba_recurso::path_pro();
		if ($archivo != "") {
		 	$path_browser .= "/" . $archivo;
		}
		return array(	"real" => $path_real,
						"browser" => $path_browser);
	}
	
	/**
	 * Retorna un path donde incluir archivos temporales, el path no es navegable
	 */
	function get_path_temp()
	{
		return toba_dir()."/temp";	
	}
	
	/**
	 * Retorna un directorio abierto a la navegaci�n donde almacenar archivos temporales
	 */
	function get_path_temp_www()
	{
		$path = $this->get_proyecto_path_www("temp");
		if (!file_exists($path['real'])) {
			mkdir($path['real'], 0700);
		}
		return $path;
	}
	
	function get_usuario()
	{
		return toba::usuario()->get_id();
	}
    
    /**
    	Devuelve un parametro del usuario.
    	Los parametros pueden ser (a,b,c)
    */
	function get_usuario_parametro($parametro)
	{
		$param = $this->get_usuario_parametros();
		if(($parametro != 'a')&&($parametro != 'b')&&($parametro != 'c')){
			throw new toba_error("El parametro '$parametro' no existe. Los parametros posibles son: 'a', 'b' y 'c'");
		}
		return $param[$parametro];
	}
	
	/*
		Devuelve todos los parametros del usuario
	*/
	function get_usuario_parametros()
	{
		$param['a'] = $_SESSION['toba']["usuario"]["parametro_a"];
		$param['b'] = $_SESSION['toba']["usuario"]["parametro_b"];
		$param['c'] = $_SESSION['toba']["usuario"]["parametro_c"];
		return $param;
	}

	function get_usuario_nivel_acceso()
/*
 	@@acceso: actividad
	@@desc: Notifica el nivel de acceso que posee el usuario
*/
	{
		return null;//$_SESSION['toba']["usuario"]["nivel_acceso"];
	}

	function get_usuario_grupo_acceso()
/*
 	@@acceso: actividad
	@@desc: Notifica el GRUPO de ACCESO del usuario
*/
	{
		return toba::sesion()->get_grupo_acceso();
	}

	function get_usuario_perfil_datos()
/*
 	@@acceso: actividad
	@@desc: Notifica el GRUPO de ACCESO del usuario
*/
	{
		return $_SESSION['toba']["usuario"]["perfil_datos"];
	}
	
	function usuario_solicita_cronometrar()
/*
 	@@acceso: nucleo
	@@desc: Notifica si se solicito registrar la cronometracion del ITEM que se esta ejecutando
*/
	{
		if(isset($this->parametros[apex_hilo_qs_cronometro])){
			return true;
		}else{
			return false;
		}
	}

	function entorno_instanciador()
/*
 	@@acceso: nucleo
	@@desc: Notifica si el ITEM que se esta ejecutando es el INSTANCIADOR de un objeto de la libreria
*/
	{
		$item = toba::hilo()->get_item_solicitado();
		if(strpos($item[0],"admin/objetos/instanciadores")) {
			return true;
		} else {
			return false;
		}
	}
	
	//----------------------------------------------------------------	
	//----------------------------------------------------------------
	//------------ MEMORIA (persistencia en $_SESSION) ---------------
	//----------------------------------------------------------------	
	//----------------------------------------------------------------	

	/**
		Inicializa la memoria
	*/
	private function inicializar_memoria()
	{
		if( $this->verificar_acceso_menu() ){
			/*
				El flag de acceso por el menu desencadena el borrado de toda la memoria pensada para
				utilizarse dentro de una operacion: los elementos de la memoria GLOBAL marcados 
				como "reciclables" y la memoria sincronizada (la alienada al request anterior).
			*/
			toba::logger()->debug('HILO: REINICIO MEMORIA (Se limpio la memoria sincroniza y global reciclable: acceso menu)', 'toba');
			$this->limpiar_memoria_sincronizada();
			$this->limpiar_memoria_global_reciclable();
		}
		$this->inicializar_reciclaje_global();
	}

	public function limpiar_memoria()
	{
		$this->limpiar_memoria_sincronizada();
		$this->limpiar_memoria_global();
	}

	public function dump_memoria()
	{
		$celda = $this->get_celda_memoria_actual();
		ei_arbol($_SESSION,"MEMORIA Completa");
	}

	public function dump_celda_memoria()
	{
		$celda = $this->get_celda_memoria_actual();
		ei_arbol($_SESSION[$celda],"CELDA de MEMORIA: $celda");
	}

	/**
		Indica cual es la celda actual
	*/
	public function get_celda_memoria_actual()
	//Indica cual es la celda de memoria que se utiliza en este REQUEST
	{
		return $this->celda_memoria_actual;
	}

	/**
		Indica si se accedio por el menu
	*/
	public function verificar_acceso_menu()
	//Indica si el request se genero desde el menu
	{
		return $this->acceso_menu;
	}

	/**
		Desactiva el reciclado
	*/
	public function desactivar_reciclado()
	{
		$this->reciclar_memoria = false;
	}

	//************************************************************************
	//*********  Persistencia GLOBAL (acceso directo a la sesion)  ***********
	//************************************************************************

	/**
		Persiste un dato global
	*/
	public function persistir_dato_global($indice, $datos, $reciclable=false, $tipo_reciclado=null)
	{
		$celda = $this->get_celda_memoria_actual();
		$_SESSION[$celda]['global'][$indice]=$datos;
		if($reciclable){
			//Defino el tipo de reciclado (por defecto se utiliza el de cambio de item)
			if(!isset($tipo_reciclado)) $tipo_reciclado = apex_hilo_reciclado_item;
			$this->agregar_dato_global_reciclable($indice, $tipo_reciclado);
		}
	}

	/**
		Recupera un dato global
	*/
	public function recuperar_dato_global($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		if($this->existe_dato_global($indice))
		{
			//Se avisa que se accedio a un dato global al sistema de reciclado
			$this->acceso_a_dato_global($indice);
			return $_SESSION[$celda]['global'][$indice];
		}else{
			return null;
		}
	}
	
	/**
		Elimina un dato global
	*/
	public function eliminar_dato_global($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		if(isset($_SESSION[$celda]['global'][$indice])){
			unset($_SESSION[$celda]['global'][$indice]);
		}
		$this->eliminar_informacion_reciclado($indice);
	}

	/**
		Chequea si un dato global existe
	*/
	public function existe_dato_global($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		return isset($_SESSION[$celda]['global'][$indice]);
	}

	/**
		Elimina TODA la informacion global
	*/
	public function limpiar_memoria_global()
	{
		$celda = $this->get_celda_memoria_actual();
		unset($_SESSION[$celda]['global']);
	}

	//----------------------------------------------------------------	
	//-------------  RECICLAJE de memoria GLOBAL ---------------------	
	//----------------------------------------------------------------	
	
	/**
		Inicializa el esquema de reciclado global
	*/
	private function inicializar_reciclaje_global()
	{
		$celda = $this->get_celda_memoria_actual();
		//-- Inicializo reciclaje por cambio de item.
		if(isset($this->item_solicitado)){
			$_SESSION[$celda]['item'] = implode('|',$this->item_solicitado);
		}else{
			$_SESSION[$celda]['item'] = 'inicio';
		}
		//-- Inicializo reciclaje por acceso.
		//		Vacio los reciclables activos para que se registren ellos.
		$_SESSION[$celda]["reciclables_activos"] = array();
		if(!isset($_SESSION[$celda]["reciclables"])){
			$_SESSION[$celda]["reciclables"] = array();
		}
		//Disparo el reciclaje por cambio de item
		$this->reciclar_datos_globales_item();
	}

	/**
		Se marca un dato global como reciclable
	*/
	private function agregar_dato_global_reciclable($indice, $tipo_reciclado)
	//Se reporta que un dato global se va a reciclar
	{
		if($tipo_reciclado != apex_hilo_reciclado_item && $tipo_reciclado != apex_hilo_reciclado_acceso ){
			//El tipo de reciclado es invalido!
			throw new toba_error('El tipo de reciclado solicitado es invalido');
		}
		if( !$this->existe_dato_reciclable($indice) ){
			$celda = $this->get_celda_memoria_actual();
			$_SESSION[$celda]["reciclables"][$indice] = $tipo_reciclado;
		}
		if($tipo_reciclado == apex_hilo_reciclado_acceso){
			//Si el tipo de reciclado es por conteo de accesos, marco al dato como activo
			$this->dato_global_activo($indice);
		}
	}
	
	/**
		Registra el acceso a datos globales para el esquema de reciclado por conteo de accesos
	*/
	private function acceso_a_dato_global($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		//Si el tipo de reciclado es por acceso, marco que el elemento fue accedido
		if( isset($_SESSION[$celda]["reciclables"][$indice]) ){
			if($_SESSION[$celda]["reciclables"][$indice]== apex_hilo_reciclado_acceso){
				$this->dato_global_activo();	
			}
		}
	}

	/**
		Setea un dato reciclable como activo en el esquema de reciclado por conteo de accesos
	*/
	private function dato_global_activo($indice)
	//Indica que el dato reciclable fue activado
	{
		$celda = $this->get_celda_memoria_actual();
		//Puede ser llamado por fuera
		if( $this->existe_dato_reciclable($indice) ){
			if(!in_array($indice,$_SESSION[$celda]["reciclables_activos"])){
				$_SESSION[$celda]["reciclables_activos"][] = $indice;
			}
		}
	}

	/**
		Reciclado de datos globales por cambio de item.
		Se debe ejecutar cuando se inicia el request
			(Si el item de la celda actual cambio, eliminar el contenido)
	*/
	private function reciclar_datos_globales_item()
	{
		$celda = $this->get_celda_memoria_actual();
		if(isset($_SESSION[$celda]['item_anterior'])){
			//Solucion parcial para que la cascada no borre los datos de la operaci�n
			$es_item_cascada = ($_SESSION[$celda]['item'] == 'toba|/basicos/ef/respuesta');
			$vino_item_cascada = ($_SESSION[$celda]['item_anterior'] == 'toba|/basicos/ef/respuesta');
			
			$es_distinto_item = ($_SESSION[$celda]['item_anterior'] != $_SESSION[$celda]['item']);
			if($es_distinto_item && !$es_item_cascada && !$vino_item_cascada) {
				toba::logger()->debug("HILO: Se limpio de la memoria con reciclaje por cambio de ITEM", 'toba');
				foreach( $_SESSION[$celda]["reciclables"] as $reciclable => $tipo){	
					if($tipo == apex_hilo_reciclado_item){
						$this->eliminar_dato_global($reciclable);
					}
				}
			}
		}
	}

	/**
		Reciclado por control de acceso a los datos guardados
		Se debe ejecutar cuando termina el request
			(Si un dato no fue accedido, borrarlo)
	*/
	private function reciclar_datos_globales_acceso()
	{
		$celda = $this->get_celda_memoria_actual();
		foreach( $_SESSION[$celda]["reciclables"] as $reciclable => $tipo){	
			if($tipo == apex_hilo_reciclado_acceso){
				//Si hay un elemento reciclable que no se activo, lo destruyo
				if(!in_array($reciclable,$_SESSION[$celda]["reciclables_activos"])){
					toba::logger()->debug("HILO: Se limpio de la memoria el elemento '$reciclable' porque no fue accedido", 'toba');
					$this->eliminar_dato_global($reciclable);
				}
			}
		}
	}

	/**
		Controla si existe un dato reciclabe
	*/
	public function existe_dato_reciclable($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		return (isset($_SESSION[$celda]["reciclables"][$indice]));
	}

	/**
		Limpia toda la memoria reciclable
	*/
	private function limpiar_memoria_global_reciclable()
	{
		$celda = $this->get_celda_memoria_actual();
		if(isset($_SESSION[$celda]["reciclables"])){
			foreach($_SESSION[$celda]["reciclables"] as $reciclable => $tipo){
				$this->eliminar_dato_global($reciclable);
			}
		}
		//Esto no deberia ser necesario.
		unset($_SESSION[$celda]["reciclables"]);
		unset($_SESSION[$celda]["reciclables_activos"]);
	}

	/**
		Elimina la informacion asociada al reciclado de un dato
	*/
	private function eliminar_informacion_reciclado($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		//Si el dato era reciclable, lo saco de las listas de reciclado
		if($this->existe_dato_reciclable($indice)){
			$tipo = $_SESSION[$celda]["reciclables"][$indice];
			//Si el reciclado es de tipo 'acceso', tengo que sacarlo de la lista de reciclables activos
			if($tipo == apex_hilo_reciclado_acceso){
				foreach(array_keys($_SESSION[$celda]["reciclables_activos"]) as $reciclable){
					if($_SESSION[$celda]["reciclables_activos"][$reciclable]==$indice){
						unset($_SESSION[$celda]["reciclables_activos"][$reciclable]);
					}
				}
			}
			unset($_SESSION[$celda]["reciclables"][$indice]);
		}
	}

	//*******************************************************************************
	//********  Persistencia SINCRONIZADA (Exclusiva para el PROXIMO request ********
	//*******************************************************************************
		
	public function persistir_dato_sincronizado($indice, $datos)
	{
		$celda = $this->get_celda_memoria_actual();
		$_SESSION[$celda]["hilo"][$this->id][$indice]=$datos;
	}

	public function recuperar_dato_sincronizado($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		if(isset($_SESSION[$celda]["hilo"][$this->hilo_referencia][$indice])){
			return $_SESSION[$celda]["hilo"][$this->hilo_referencia][$indice];
		}else{
			return null;
		}
	}

	public function eliminar_dato_sincronizado($indice)
	{
		$celda = $this->get_celda_memoria_actual();
		if(isset($_SESSION[$celda]["hilo"][$this->id][$indice])){
			unset($_SESSION[$celda]["hilo"][$this->id][$indice]);
		}
	}

	public function limpiar_memoria_sincronizada()
	{
		$celda = $this->get_celda_memoria_actual();
		unset($_SESSION[$celda]["hilo"]);
	}

	private function reciclar_datos_sincronizados()
	//Ejecuto la recoleccion de basura de la MEMORIA SINCRONIZADA
	{
		$celda = $this->get_celda_memoria_actual();
		if(isset($_SESSION[$celda]["hilo"])){
			if(count($_SESSION[$celda]["hilo"]) > apex_hilo_tamano ){
				array_shift($_SESSION[$celda]["hilo"]);
			}
		}
	}

	//*******************************************************************************
	//** Compatibilidad inversa con la version anterior
	//*******************************************************************************

	/**
	 * @deprecated Usar persistir dato sincronizado
	 */	
	public function persistir_dato($indice, $datos)
	{
		toba::logger()->obsoleto(__CLASS__, __FUNCTION__, '0.8.3');
		$this->persistir_dato_sincronizado($indice, $datos);
	}

	/**
	 * @deprecated Usar eliminar dato sincronizado
	 */	
	public function eliminar_dato($indice)
	{
		toba::logger()->obsoleto(__CLASS__, __FUNCTION__, '0.8.3');
		$this->eliminar_dato_sincronizado($indice);
	}

	/**
	 * @deprecated Usar recuperar dato sincronizado
	 */
	public function recuperar_dato($indice)
	{
		toba::logger()->obsoleto(__CLASS__, __FUNCTION__, '0.8.3');
		return $this->recuperar_dato_sincronizado($indice);
	}

	//----------------------------------------------------------------	
	//----------------------------------------------------------------
	//---------------- MANEJO de ARCHIVOS de SESION ------------------
	//----------------------------------------------------------------	
	//----------------------------------------------------------------	
/*
	Estas funciones pertinen manejar el ciclo de vida de archivos
	cargados con UPLOADS que son solo validos durante la sesion.
	La eliminacion de estos archivos esta en el evento cerrar de la sesion
*/
	function registrar_archivo($archivo){
		if(	!isset($_SESSION['toba']['archivos']) 
			|| !in_array($archivo, $_SESSION['toba']['archivos'])){
			$_SESSION['toba']["archivos"][] = $archivo;
		}
	}
	
	//----------------------------------------------------------------	
	//----------------------------------------------------------------
	//-------------------- EVENTOS de SESION TOBA --------------------
	//----------------------------------------------------------------
	//----------------------------------------------------------------	
/*
* Las funciones que siguen generan dos links ESPECIALES que se atrapan antes que cualquier 
* proxima ACTIVIDAD (Antes de que exista la proxima solicitud). 
* Estos links implican EVENTOS de SESION. Estan metidos en el hilo porque
* Hacen referencia al estado actual (especificamente a la eliminacion del estado actual)
* Hasta ahora estas funciones solo se llaman desde el CONTROL.
*/

	function finalizar()
/*
 	@@acceso: nucleo
	@@desc: Crea el vinculo que hay que llamar para eliminar la SESION...
*/
	{
		return $this->prefijo_vinculo() ."&". apex_sesion_qs_finalizar . "=1";
	}	

}
?>
