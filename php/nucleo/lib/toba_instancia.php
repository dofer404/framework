<?php
/**
 * Datos de ACCESO y AUDITORIA necesarios para el funcionamiento del nucleo.
 * Enmascara principalmente al archivo de configuraci�n instancia.ini de la instancia actual
 * 
 * @package Centrales
 */
class toba_instancia
{
	static private $instancia;
	static protected $id;
	protected $id_solicitud;
	private $memoria;							//Referencia al segmento de $_SESSION asignado
		
	/**
	 * @return toba_instancia
	 */
	static function instancia($recargar=false)
	{
		if (!isset(self::$instancia) || $recargar) {
			self::$instancia = new toba_instancia($recargar);	
		}
		return self::$instancia;	
	}

	static function eliminar_instancia()
	{
		self::$instancia = null;
	}

	private function __construct($recargar)
	{
		$this->memoria =& toba::manejador_sesiones()->segmento_info_instancia();
		if(!$this->memoria || $recargar) {
			$this->memoria = $this->get_datos_instancia( self::get_id() );
		}
	}
	
	/**
	 * Retorna el contenido del archivo instancia.ini de la instancia 
	 */
	static function get_datos_instancia($id_instancia)
	{
		$archivo = toba::nucleo()->toba_instalacion_dir().'/i__' . $id_instancia . '/instancia.ini';
		if ( is_file( $archivo ) ) {
			return parse_ini_file( $archivo, true );
		} else {
			throw new toba_error("INFO_INSTANCIA: No se encuentra definido el archivo de inicializacion de la INSTANCIA: '".self::get_id()."' ('$archivo')");
		} 	
	}
	
	/**
	 * Retorna el id de la instancia actual
	 * La configuracion puede estar cono variable de entorno del servidor o una constante del PA
	 */
	static function get_id()
	{
		if ( ! isset(self::$id)) {
			if (defined('apex_pa_instancia')) {
				self::$id = apex_pa_instancia;
			} elseif (isset($_SERVER['TOBA_INSTANCIA'])) {
				self::$id = $_SERVER['TOBA_INSTANCIA'];
			} else {
				throw new toba_error("INFO_INSTANCIA: La INSTANCIA ACTUAL no se encuentra definida (no exite la variable de entorno TOBA_INSTANCIA ni la constante 'apex_pa_instancia')");
			}
		}		
		return self::$id;
	}
	
	/**
	 * Retorna un vinculo a la base de datos que forma parte de la instancia
	 * @return toba_db
	 */
	function get_db()
	{
		if ( isset( $this->memoria['base'] ) ) {
			return toba_dba::get_db($this->memoria['base']);
		} else {
			throw new toba_error("INFO_INSTANCIA: El archivo de inicializacion de la INSTANCIA: '".self::$id."' no posee una BASE DEFINIDA");
		}
	}
	
	function get_schema_db()
	{
		$parametros = toba_dba::get_parametros_base($this->memoria['base']);
		if (isset($parametros['schema'])) {
			return $parametros['schema'];
		}
	}
	
	/**
	 * @return toba_modelo_instancia
	 */
	protected function get_modelo_instancia()
	{
		$catalogo = toba_modelo_catalogo::instanciacion();
		$catalogo->set_db($this->get_db());
		return $catalogo->get_instancia($this->get_id());		
	}
	
	/**
	 * Retorna el path absoluto de un proyecto perteneciente a esta instancia
	 */
	function get_path_proyecto($proyecto)
	{
		//incluyo el archivo de informacion basica de la INSTANCIA
		if ($proyecto == 'toba') {
			return toba::instalacion()->get_path();	
		} elseif (isset($this->memoria[$proyecto]['path'])) {
			$path = $this->memoria[$proyecto]['path'];
			if (substr($path, 0, 1) == '.') {
				return realpath(toba_dir().'/'.$this->memoria[$proyecto]['path']);
			} else {
				return $this->memoria[$proyecto]['path'];
			}
		} else {
			return toba_dir() . "/proyectos/" . $proyecto;
		}
	}

	function get_directiva_compilacion($proyecto)
	{
		if (isset($this->memoria[$proyecto]['metadatos_compilados'])) {
			return $this->memoria[$proyecto]['metadatos_compilados'];
		}
		return null;
	}
	
	//----------------------------------------------------------------
	// DATOS
	//----------------------------------------------------------------

	//------------------------- LOG aplicacion -------------------------------------

	function get_id_solicitud()
	{
		if (! isset($this->id_solicitud)) {
			$sql = "SELECT	nextval('apex_solicitud_seq'::text) as id;";	
			$rs = $this->get_db()->consultar($sql);
			if (empty($rs)) {
				throw new toba_error('No es posible generar un ID para la solicitud');
			}
			$this->id_solicitud = $rs[0]['id'];
		}
		return $this->id_solicitud;
	}

	
	function registrar_solicitud($id, $proyecto, $item, $tipo_solicitud)
	{
		$tiempo = toba::cronometro()->tiempo_acumulado();
		$sql = "INSERT	INTO apex_solicitud (proyecto, solicitud, solicitud_tipo, item_proyecto, item, tiempo_respuesta)	
				VALUES (:proyecto, :solicitud, :solicitud_tipo,:item_proyecto, :item, :tiempo_respuesta);";	

		$parametros = array(
			'proyecto' => $proyecto,
			'solicitud' => $id,
			'solicitud_tipo' => $tipo_solicitud,
			'item_proyecto' => $proyecto,
			'item' => $item,
			'tiempo_respuesta' => $tiempo
		);
		$this->get_db()->sentencia($sql, $parametros);
	}

	function registrar_solicitud_observaciones( $proyecto, $id, $tipo, $observacion )
	{
		
		$sql = "INSERT	INTO apex_solicitud_observacion (proyecto, solicitud, solicitud_obs_tipo_proyecto, solicitud_obs_tipo, observacion)	
				VALUES (:proyecto, :solicitud, :solicitud_obs_tipo_proyecto,:solicitud_obs_tipo, :observacion);";	

		$parametros = array(
			'proyecto' => $proyecto,
			'solicitud' => $id,
			'solicitud_tipo' => $tipo[0],
			'solicitud_obs_tipo_proyecto' => $tipo[1],
			'observacion' => $observacion
		);
		$this->get_db()->sentencia($sql, $parametros);		
	}

	function registrar_solicitud_browser($proyecto, $id, $sesion_proyecto, $sesion, $ip)
	{
		$sql = "INSERT	INTO apex_solicitud_browser (solicitud_proyecto, solicitud_browser, proyecto, sesion_browser, ip)	
				VALUES (:solicitud_proyecto, :solicitud_browser, :proyecto, :sesion_browser, :ip);";	

		$parametros = array(
			'solicitud_proyecto' => $proyecto,
			'solicitud_browser' => $id,
			'proyecto' => $sesion_proyecto,
			'sesion_browser' => $sesion,
			'ip' => $ip
		);
		$this->get_db()->sentencia($sql, $parametros);		
	}

	function registrar_solicitud_consola($proyecto, $id, $usuario, $llamada)
	{
		$sql = "INSERT INTO apex_toba_solicitud_consola (proyecto, toba_solicitud_consola, usuario, llamada) 
				VALUES (:proyecto,:toba_solicitud_consola, :usuario, :llamada);";
		$parametros = array(
			'proyecto' => $proyecto,
			'toba_solicitud_consola' => $id,
			'usuario' => $usuario,
			'llamada' => $llamada
		);
		$this->get_db()->sentencia($sql, $parametros);		
	}

	function registrar_marca_cronometro($proyecto, $solicitud, $marca, $nivel, $texto, $tiempo)
	{
		$sql = "INSERT INTO apex_solicitud_cronometro(proyecto, solicitud, marca, nivel_ejecucion, texto, tiempo) 
				VALUES (:proyecto, :solicitud, :marca, :nivel_ejecucion, :texto, :tiempo);";
		$parametros = array(
			'proyecto' => $proyecto,
			'solicitud' => $solicitud,
			'marca' => $marca,
			'nivel_ejecucion' => $nivel,
			'texto' => $texto,
			'tiempo' => $tiempo
		);
		$this->get_db()->sentencia($sql, $parametros);		
	}

	//------------------ Relacion entre PROYECTOS --------------------------
	
	/**
	 * Retorna las urls de los proyectos actualmente inclu�dos en la instancia
	 */
	function get_url_proyectos($proys)
	{
		$salida = array();
		foreach ($proys as $pro) {
			$salida[$pro] = $this->get_url_proyecto($pro);
		}
		return $salida;
	}
	
	/**
	 * Retorna las url asociada a un proyecto particular de la instancia
	 */	
	function get_url_proyecto($proy)
	{
		if (isset($this->memoria[$proy]['url'])) {
			return $this->memoria[$proy]['url'];
		} elseif (toba::proyecto()->get_id() == $proy && isset($_SERVER['TOBA_PROYECTO_ALIAS'])) {
			//---Es el actual y hay una directiva en el ALIAS
			return '/'.$_SERVER['TOBA_PROYECTO_ALIAS'];
		} else {
			return '/'.$proy;
		}
	}

	/**
	 * Retorna la lista de proyectos a los cuales el usuario actual puede ingresar
	 */
	function get_proyectos_accesibles($refrescar=false)
	{
		if ($refrescar || ! isset($this->memoria['proyectos_accesibles'])) {
			$usuario = toba::usuario()->get_id();
			$sql = "SELECT 		p.proyecto, 
	    						p.descripcion_corta
	    				FROM 	apex_proyecto p,
	    						apex_usuario_proyecto up
	    				WHERE 	p.proyecto = up.proyecto
						AND  	listar_multiproyecto = 1 
						AND		up.usuario = '$usuario'
						ORDER BY orden;";
			$this->memoria['proyectos_accesibles'] =
					 $this->get_db()->consultar($sql, toba_db_fetch_num);
		}
		return $this->memoria['proyectos_accesibles'];
	}

	//--------------------------------------------------------------------------
	//-------------------- LOGIN USUARIOS --------------------------------------------
	//--------------------------------------------------------------------------

	/**
	 * Retorna la informaci�n cruda de un usuario, tal como est� en la base de datos
	 * Para hacer preguntas del usuario actual utilizar toba::usuario()->
	 *
	 * @see toba_usuario
	 */
	function get_info_usuario($usuario)
	{
		$sql = "SELECT	usuario as							id,
						nombre as							nombre,
						hora_salida as						hora_salida,
						solicitud_registrar as				sol_registrar,
						solicitud_obs_tipo_proyecto as		sol_obs_tipo_proyecto,
						solicitud_obs_tipo as				sol_obs_tipo,
						solicitud_observacion as			sol_obs,
						parametro_a as						parametro_a,
						parametro_b as 						parametro_b,
						parametro_c as						parametro_c
				FROM 	apex_usuario u
				WHERE	usuario = '$usuario'";
		$rs = $this->get_db()->consultar($sql);
		if(empty($rs)){
			throw new toba_error("El usuario '$usuario' no existe.");
		}
		return $rs[0];
	}

	function get_info_autenticacion($usuario)
	{
		try {
			$sql = "SELECT clave, autentificacion FROM apex_usuario WHERE usuario = :usuario";
			$id = $this->get_db()->sentencia_preparar($sql);
			$rs = $this->get_db()->sentencia_consultar($id, array('usuario'=>$usuario));
			if(!empty($rs))	return $rs[0];
		} catch (toba_error_db $e ) {
			toba::logger()->debug($e->getMessagge());
			throw new toba_error('Error recuperando informacion');
		}
	}

	/**
	*	Devuelve los grupos de acceso de un usuario para un proyecto
	*/
	function get_grupos_acceso($usuario, $proyecto)
	{
		$sql = "SELECT	up.usuario_grupo_acc as 				grupo_acceso
				FROM 	apex_usuario_proyecto up,
						apex_usuario_grupo_acc ga
				WHERE	up.usuario_grupo_acc = ga.usuario_grupo_acc
				AND		up.proyecto = ga.proyecto
				AND		up.usuario = '$usuario'
				AND		up.proyecto = '$proyecto';";
		$datos = $this->get_db()->consultar($sql);
		if($datos){
			$grupos = array();
			foreach($datos as $dato) {
				$grupos[] = $dato['grupo_acceso'];
			}
			return $grupos;
		} else {
			return array();
		}
	}
	
	/**
	*	Utilizada en el login automatico
	*/
	function get_lista_usuarios()
	{
		$sql = "SELECT 	DISTINCT 
						u.usuario as usuario, 
						u.nombre as nombre
				FROM 	apex_usuario u, apex_usuario_proyecto p
				WHERE 	u.usuario = p.usuario
				AND		p.proyecto = '".toba_proyecto::get_id()."'
				ORDER BY 1;";
		return $this->get_db()->consultar($sql);	
	}

	//-------------------- Bloqueo de IPs en LOGIN  ----------------------------

	function es_ip_rechazada($ip)
	{
		$sql = "SELECT '1' FROM apex_log_ip_rechazada WHERE ip = :ip";
		$id = $this->get_db()->sentencia_preparar($sql);
		$rs = $this->get_db()->sentencia_consultar($id, array('ip'=>$ip));
		if ( empty($rs)) {
			return false;
		}
		return true;
	}
	
	function registrar_error_login($usuario, $ip, $texto)
	{
		$texto = addslashes($texto);
		$sql = "INSERT INTO apex_log_error_login(usuario,clave,ip,gravedad,mensaje) VALUES ( :usuario, NULL, :ip,'1',:texto)";
		try {
			$id = $this->get_db()->sentencia_preparar($sql);
			$this->get_db()->sentencia_ejecutar($id, array('usuario'=>$usuario,'ip'=>$ip,'texto'=>$texto));
		} catch ( toba_error_db $e) {
			throw new toba_error('Error');
		}
	}

	function bloquear_ip($ip)
	{
		try {
			$sql = "INSERT INTO apex_log_ip_rechazada (ip) VALUES (:ip)";
			$id = $this->get_db()->sentencia_preparar($sql);
			$this->get_db()->sentencia_ejecutar($id, array('ip'=>$ip));
		} catch ( toba_error $e ) {
			//La ip ya esta rechazada	
		}
	}
	
	function get_cantidad_intentos_en_ventana_temporal($ip, $ventana_temporal=null)
	{
		$sql = "SELECT count(*) as total FROM apex_log_error_login WHERE ip = :ip AND (gravedad > 0)";
		$parametros['ip'] = $ip;
		if (isset($ventana_temporal)) {
			$sql .= " AND ((now()-momento) < :ventana_temporal)";
			$parametros['ventana_temporal'] = $ventana_temporal . ' min';
		}
		try {
			$id = $this->get_db()->sentencia_preparar($sql);
			$rs = $this->get_db()->sentencia_consultar($id, $parametros);
			return $rs[0]['total'];
		} catch ( toba_error_db $e) {
			throw new toba_error('Error!');
		}
	}
	
	//-------------------- Bloqueo de Usuarios en LOGIN  ----------------------------
	
	
	function get_cantidad_intentos_usuario_en_ventana_temporal($usuario, $ventana_temporal=null)
	{
		$sql = "SELECT count(*) as total FROM apex_log_error_login WHERE usuario = :usuario AND (gravedad > 0)";
		$parametros['usuario'] = $usuario;
		if (isset($ventana_temporal)) {
			$sql .= " AND ((now()-momento) < :ventana_temporal)";
			$parametros['ventana_temporal'] = $ventana_temporal . ' min';
		}
		try {
			$id = $this->get_db()->sentencia_preparar($sql);
			$rs = $this->get_db()->sentencia_consultar($id, $parametros);
			return $rs[0]['total'];
		} catch ( toba_error_db $e) {
			throw new toba_error('Error!');
		}
	}
	
	function bloquear_usuario($usuario)
	{
		try {
			$sql = "UPDATE apex_usuario SET bloqueado = 1 WHERE usuario = :usuario";
			$id = $this->get_db()->sentencia_preparar($sql);
			$this->get_db()->sentencia_ejecutar($id, array('usuario'=>$usuario));
		} catch ( toba_error $e ) {
			//el usuario ya esta bloqueado
		}
	}
	
	function es_usuario_bloqueado($usuario)
	{
		$sql = "SELECT '1' FROM apex_usuario WHERE usuario = :usuario AND bloqueado = 1";
		$id = $this->get_db()->sentencia_preparar($sql);
		$rs = $this->get_db()->sentencia_consultar($id, array('usuario'=>$usuario));
		if ( empty($rs)) {
			return false;
		}
		return true;
	}
	
	//--------------------------------------------------------------------------
	//------------------------- SESION -------------------------------------
	//--------------------------------------------------------------------------
	
	function get_id_sesion()
	{
		$sql = "SELECT nextval('apex_sesion_browser_seq'::text) as id;";
		$rs = $this->get_db()->consultar($sql);
		if(empty($rs)){
			throw new toba_error("No es posible recuperar el ID de la sesion.");
		}
		return $rs[0]['id'];
	}
	
	function abrir_sesion($sesion, $usuario, $proyecto)
	{
		$sql = "INSERT INTO apex_sesion_browser(sesion_browser, usuario, ip, proyecto, php_id) 
				VALUES (:sesion_browser, :usuario, :ip, :proyecto, :php_id);";
		$ip = isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : null;		
		$parametros = array(
			'sesion_browser' => $sesion,
			'usuario' => $usuario,
			'ip' => $ip,
			'proyecto' => $proyecto,
			'php_id' => session_id(),
		);
		$this->get_db()->sentencia($sql, $parametros);		
	}
	
	function cerrar_sesion($sesion, $observaciones = null)
	{
		$db = $this->get_db();
		$sesion = $db->quote($sesion);
		if (isset($observaciones)){
			$observaciones = $db->quote($observaciones);
			$sql = "UPDATE apex_sesion_browser SET egreso = current_timestamp, observaciones=$observaciones WHERE sesion_browser = $sesion;";
		}else{
			$sql = "UPDATE apex_sesion_browser SET egreso = current_timestamp WHERE sesion_browser = $sesion;";
		}		
		$db->ejecutar($sql);
	}

	//--------------------------------------------------------------------------
	//------------------------ Administracion de USUARIOS
	//--------------------------------------------------------------------------

	/**
	 *	Crea un nuevo usuario en la instancia 
	 *
	 * @param string $usuario
	 * @param string $nombre
	 * @param string $clave
	 * @param array $atributos asociativo campo => valor
	 */
	function agregar_usuario( $usuario, $nombre, $clave , $atributos=array())
	{
		$this->get_modelo_instancia()->agregar_usuario($usuario, $nombre, $clave, null, $atributos);
	}
	
	function vincular_usuario( $proyecto, $usuario, $perfil_acceso, $perfil_datos=array(), $set_previsualizacion=true )
	{
		$this->get_modelo_instancia()->get_proyecto($proyecto)->vincular_usuario($usuario, $perfil_acceso, $perfil_datos, $set_previsualizacion);
	}	

	function desbloquear_usuario($usuario)
	{
		$sql = "UPDATE apex_usuario SET bloqueado = 0 WHERE usuario = :usuario";
		$id = $this->get_db()->sentencia_preparar($sql);
		$this->get_db()->sentencia_ejecutar($id, array('usuario'=>$usuario));
	}	
}
?>