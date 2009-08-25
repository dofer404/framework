<?php
define('toba_db_fetch_asoc', PDO::FETCH_ASSOC);
define('toba_db_fetch_num', PDO::FETCH_NUM);

//Separador de campos en sentecias extraidas con SQL
define("apex_sql_separador","%%");			//Separador utilizado para diferenciar campos de valores compuestos
//Comodines concatenadores de SQL
define("apex_sql_where","%w%");
define("apex_sql_from","%f%");


/**
* Representa una conexi�n a la base de datos. Permite ejecutar comandos y consultas SQL
* En forma predeterminada utiliza los drivers PDO que tiene php desde la versi�n 5.1
* @package Fuentes
*/
class toba_db
{
	protected $conexion;	//Recurso
	protected $motor;
	protected $profile;
	protected $usuario;
	protected $clave;
	protected $base;
	protected $puerto;
	protected $debug = false;
	protected $loguear = false;
	protected $debug_sql_id = 0;
	protected $parser_errores = null;
	protected $sentencias = array();
	
	/**
	 * @param string $profile Host donde se localiza el servidor
	 * @param string $usuario Nombre del usuario utilizado para conectar
	 * @param string $clave
	 * @param string $base Nombre de la base a conectar
	 * @param string $puerto (opcional) n�mero de puerto al que se conecta
	 */
	function __construct($profile, $usuario, $clave, $base, $puerto=null)
	{
		$this->profile  = $profile;
		$this->usuario  = $usuario;
		$this->clave    = $clave;
		$this->base     = $base;
		$this->puerto = $puerto;
	}
	
	
	function set_parser_errores(toba_parser_error_db $parser)
	{
		$this->parser_errores = $parser;
	}

	/**
	 * Libera la conexi�n a la base
	 */
	function destruir()
	{
		$this->conexion = null;	
	}	
	
	/**
	*	Crea una conexion a la base
	*	@throws toba_error_db en caso de error
	*/
	function conectar()
	{
		if(!isset($this->conexion)) {
			try {
				$opciones = array();
				//--- Comentado por que da warning en php 5.2
				//$opciones =	array(PDO::ATTR_PERSISTENT => false);
				$this->conexion = new PDO($this->get_dsn(), $this->usuario, $this->clave, $opciones);
				$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				toba::logger()->error("No es posible realizar la conexi�n a la base. Mensaje: " . $e->getMessage() );				
				$ee = new toba_error_db($e, null, $this->parser_errores, false);
				throw $ee;				
			}
		}
	}		
	
	/**
	 * Retorna una referencia al objeto PDO interno
	 * @return PDO
	 */
	function get_pdo()
	{
		return $this->conexion;
	}
	
	/**
	 * Retorna los par�metros con los que fue construida la conexi�n
	 * @return array
	 */
	function get_parametros()
	{
		$parametros['HOST'] = $this->profile;
		$parametros['USUARIO'] = $this->usuario;
		$parametros['CLAVE'] = $this->clave;
		$parametros['BASE'] = $this->base;
		return $parametros;
	}

	/**
	 * Cuando la conexi�n esta en modo debug se imprime cada consulta/comando realizado
	 * @param boolean $loguear No deja las querys en el logger, solo se mantienen durante el pedido de p�gina
	 */
	function set_modo_debug($debug=true, $loguear=true)
	{
		$this->debug = $debug;
		$this->loguear = $loguear;
	}
	
	/**
	 * @ignore 
	 */
	protected function log_debug_inicio($sql)
	{
		$id = $this->debug_sql_id++;
		$this->debug_sqls[$id] = array('sql' => $sql, 'inicio' => microtime(true));
		if ($this->loguear) {
			toba_logger::instancia()->debug("***SQL[$id] : $sql");
		}
	}
	
	/**
	 * @ignore
	 */
	protected function log_debug_fin()
	{
		$this->debug_sqls[$this->debug_sql_id - 1]['fin'] = microtime(true);
	}	
	
	/**
	 * Retorna un arreglo con informacion de las distintas consultas/comandos ejecutados 
	 * Requiere haber activado el modo debug con set_modo_debug
	 */
	function get_info_debug()
	{
		if (isset($this->debug_sqls)) {
			return $this->debug_sqls;
		} else {
			return array();
		}
	}

	//------------------------------------------------------------------------
	//-- Primitivas BASICAS
	//------------------------------------------------------------------------
	/**
	 * Devuelve el valor que es considerado por el motor para asignar el valor
	 * Default en la base.
	 * @return mixed
	 */
	function get_semantica_valor_defecto()
	{
		return 'NULL';
	}

	/**
	 * Convierte un string a una representaci�n segura para el motor. Evita
	 * la inyecci�n de c�digo malicioso dentro de la sentencia SQL
	 * @param mixed $dato Puede ser un string o un arreglo
	 */
	function quote($dato)
	{
		if (! is_array($dato)) {
			return $this->conexion->quote($dato);
		} else {
			$salida = array();
			foreach (array_keys($dato) as $clave) {
				$salida[$clave] = $this->quote($dato[$clave]); 
			}
			return $salida;
		}
	}
	
	/**
	*	Ejecuta un comando sql o un conjunto de ellos
	*	@param mixed $sql Comando o arreglo de comandos
	*	@throws toba_error_db en caso de que algun comando falle	
	*/
	function ejecutar($sql)
	{
		$afectados = 0;
		if (is_array($sql)) {
			foreach(array_keys($sql) as $id) {
				try {
					if ($this->debug) $this->log_debug_inicio($sql[$id]);
					$afectados += $this->conexion->exec($sql[$id]);
					if ($this->debug) $this->log_debug_fin();
				} catch (PDOException $e) {
					toba::logger()->error($e->getMessage());
					$ee = new toba_error_db($e, $this->cortar_sql($sql), $this->parser_errores, true);
					throw $ee;
				}
			}
		} else {
			try {
				if ($this->debug) $this->log_debug_inicio($sql);
				$afectados += $this->conexion->exec($sql);
				if ($this->debug) $this->log_debug_fin();
			} catch (PDOException $e) {
				toba::logger()->error($e->getMessage());
				$ee = new toba_error_db($e, $this->cortar_sql($sql), $this->parser_errores, true);
				throw $ee;
			}
		}
		return $afectados;
	}

	/**
	*	Crea una PDO_STATEMENT y lo ejecuta.
	*	@param string $sql Consulta
	*	@param mixed $parametros Arreglo de parametros para el statement. Si el SQL poseia
	*			marcadores de tipo '?', hay que pasar un array posicional, si poseia marcadores
	*			de tipo 'nombre:', hay que pasar un array asociativo.
	*	@throws toba_error_db en caso de que algun comando falle	
	*/
	function sentencia($sql, $parametros=null)
	{
		$afectados = 0;
		try {
			if ($this->debug) $this->log_debug_inicio($sql);			
			$stm = $this->conexion->prepare($sql);
			$stm->execute($parametros);
			if ($this->debug) $this->log_debug_fin();			
			$afectados += $stm->rowCount();
		} catch (PDOException $e) {
			toba::logger()->error($e->getMessage());
			$ee = new toba_error_db($e, $this->cortar_sql($sql), $this->parser_errores, true);
			throw $ee;
		}
		return $afectados;
	}

	/**
	*	Ejecuta una consulta sql
	*	@param string $sql Consulta
	*	@param string $tipo_fetch Modo Fetch de ADO, por defecto toba_db_fetch_asoc
	*	@return array Resultado de la consulta en formato recordset (filas x columnas), 
	* 				un arreglo vacio en caso que la consulta no retorne datos, usar if (empty($resultado)) para chequearlo
	*	@throws toba_error_db en caso de error
	*/	
	function consultar($sql, $tipo_fetch=toba_db_fetch_asoc)
	{
		if (! isset($tipo_fetch)) {
			$tipo_fetch=toba_db_fetch_asoc;	
		}
		try {
			if ($this->debug) $this->log_debug_inicio($sql);
			$statement = $this->conexion->query($sql);
			if ($this->debug) $this->log_debug_fin($sql);
			return $statement->fetchAll($tipo_fetch);
		} catch (PDOException $e) {
			toba::logger()->error($e->getMessage());
			$ee = new toba_error_db($e, $this->cortar_sql($sql), $this->parser_errores, false);
			throw $ee;
		}
	}
	
	/**
	*	Ejecuta una consulta sql y retorna la primer fila del resultado.
	* 	Es �til cuando se sabe de antemano que el resultado es una �nica fila
	* 	
	*	@param string $sql Consulta SQL
	*	@param string $tipo_fetch Modo Fetch de ADO, por defecto toba_db_fetch_asoc
	*	@return array Arreglo asociativo columna=>valor, falso en caso de resultado vacio
	*	@throws toba_error_db en caso de error
	*/		
	function consultar_fila($sql, $tipo_fetch=toba_db_fetch_asoc, $lanzar_excepcion=true)
	{
		if (! isset($tipo_fetch)) {
			$tipo_fetch=toba_db_fetch_asoc;	
		}		
		try {
			if ($this->debug) $this->log_debug_inicio($sql);
			$statement = $this->conexion->query($sql);
			if ($this->debug) $this->log_debug_fin();
			return $statement->fetch($tipo_fetch);
		} catch (PDOException $e) {
			toba::logger()->error($e->getMessage());			
			if ($lanzar_excepcion) {
				$ee = new toba_error_db($e, $this->cortar_sql($sql), $this->parser_errores, false);
				throw $ee;
			} else {
				return $e->getMessage();
			}
		}		
	}

	
	/**
	*	Ejecuta una consulta sql y retorna true si existen datos
	* 	Es �til cuando solo se quiere saber si una condicion se cumple o no en la base
	* 	
	*	@param string $sql Consulta SQL
	*	@return boolean Verdadero si la consulta retorna al menos una registro
	*	@throws toba_error_db en caso de error
	*/	
	function hay_datos($sql)
	{
		$datos = $this->consultar($sql);
		return !empty($datos);
	}

	/**
	*	Ejecuta los comandos disponibles en un archivo
	*	@param string $archivo Path absoluto del archivo
	*/
	function ejecutar_archivo($archivo)
	{
		if (!file_exists($archivo)) {
			throw new toba_error("Error al ejecutar comandos. El archivo '$archivo' no existe");
		}
		$str = file_get_contents($archivo);
		//if( trim($str) != '' ) {	//Esto estaba asi porque la ejecusion de algo vacio falla.
		return $this->ejecutar($str);
		//}
	}

	//------------------------------------------------------------------------
	//----------- Manejo de Sentencias Preparadas ----------------------------
	//------------------------------------------------------------------------

	/**
	*	Prepara una sentencia para su ejecucion posterior.
	* 	
	*	@param string $sql Consulta SQL
	*	@param array $opciones Arreglo con parametros del driver
	*	@return integer ID de la sentencia, necesario para ejecutarla posteriormente con 'ejecutar_sentencia($id)'
	*	@throws toba_error_db en caso de error
	*/		
	function sentencia_preparar($sql, $opciones=array())
	{
		$id = count($this->sentencias);
		$this->sentencias[$id] = array('sql' => $sql);
		$this->sentencias[$id]['id'] = $this->conexion->prepare($sql, $opciones);
		if ($this->sentencias[$id]['id'] === false ) {
			throw new toba_error_db($e, "Error preparando la sentencia. " . $this->cortar_sql($sql), $this->parser_errores, true);
		}
		return $id;
	}
	
	/**
	*	Ejecuta una sentencia SQL preparada con 'preparar_sentencia'.
	* 	
	*	@param integer ID de la sentencia
	*	@param array Arreglo con parametros de la sentencia
	*	@param string $tipo_fetch Modo Fetch de ADO, por defecto toba_db_fetch_asoc
	*	@return integer Cantidad de registros afectados
	*	@throws toba_error_db en caso de error
	*/		
	function sentencia_ejecutar($id, $parametros=array())
	{
		if(!isset($this->sentencias[$id]['id'])) {
			throw new toba_error("La sentencia solicitada no existe.");
		}
		try {
			if ($this->debug) $this->log_debug_inicio($this->sentencias[$id]['sql']);
			$this->sentencias[$id]['id']->execute($parametros);
			if ($this->debug) $this->log_debug_fin();
			return $this->sentencias[$id]['id']->rowCount();
		} catch (PDOException $e) {
			$ee = new toba_error_db($e, $this->cortar_sql($this->sentencias[$id]['sql']), $this->parser_errores, true);
			$ee->set_mensaje_motor($e->getMessage());
			throw $ee;
		}		
	}

	/**
	*	Ejecuta una sentencia SQL preparada con 'preparar_sentencia'.
	* 	
	*	@param integer ID de la sentencia
	*	@param array Arreglo con parametros de la sentencia
	*	@param string $tipo_fetch Modo Fetch de ADO, por defecto toba_db_fetch_asoc
	*	@return array Resultado de la consulta en formato recordset (filas x columnas), 
	* 				un arreglo vacio en caso que la consulta no retorne datos, usar if (empty($resultado)) para chequearlo
	*	@throws toba_error_db en caso de error
	*/		
	function sentencia_consultar($id, $parametros=array(), $tipo_fetch=toba_db_fetch_asoc)
	{
		if (!isset($this->sentencias[$id]['id'])) {
			throw new toba_error("La sentencia solicitada no existe.");
		}
		try {
			if ($this->debug) $this->log_debug_inicio($this->sentencias[$id]['sql']);
			$this->sentencias[$id]['id']->execute($parametros);
			if ($this->debug) $this->log_debug_fin();
			return $this->sentencias[$id]['id']->fetchAll($tipo_fetch);
		} catch (PDOException $e) {
			$ee = new toba_error_db($e, $this->cortar_sql($this->sentencias[$id]['sql']), $this->parser_errores, true);
			$ee->set_mensaje_motor($e->getMessage());
			throw $ee;
		}		
	}

	/**
	*	Ejecuta una sentencia SQL preparada con 'preparar_sentencia' y retorna la primer fila del resultado
	*
	*	@param integer ID de la sentencia
	*	@param array Arreglo con parametros de la sentencia
	*	@param string $tipo_fetch Modo Fetch de ADO, por defecto toba_db_fetch_asoc
	*	@return array Resultado de la consulta en formato recordset (filas x columnas),
	* 				un arreglo vacio en caso que la consulta no retorne datos, usar if (empty($resultado)) para chequearlo
	*	@throws toba_error_db en caso de error
	*/
	function sentencia_consultar_fila($id, $parametros=array(), $tipo_fetch=toba_db_fetch_asoc, $lanzar_excepcion=true)
	{

		if (!isset($this->sentencias[$id]['id'])) {
			throw new toba_error("La sentencia solicitada no existe.");
		}
		try {
			if ($this->debug) $this->log_debug_inicio($this->sentencias[$id]['sql']);
			$this->sentencias[$id]['id']->execute($parametros);
			if ($this->debug) $this->log_debug_fin();
			return $this->sentencias[$id]['id']->fetch($tipo_fetch);
		} catch (PDOException $e) {
			$ee = new toba_error_db($e, $this->cortar_sql($this->sentencias[$id]['sql']), $this->parser_errores, true);
			$ee->set_mensaje_motor($e->getMessage());
			throw $ee;
		}
	}

	/**
	*	Retorna un formato recordset a partir de una sentencia ejecutada
	*	@param integer ID de la sentencia
	*	@param string $tipo_fetch Modo Fetch de ADO, por defecto toba_db_fetch_asoc
	*	@return array Resultado de la consulta en formato recordset (filas x columnas)
	*/
	function sentencia_datos($id, $tipo_fetch=toba_db_fetch_asoc)
	{
		if(!isset($this->sentencias[$id]['id'])) {
			throw new toba_error("La sentencia solicitada no existe.");
		}
		return $this->sentencias[$id]['id']->fetchAll($tipo_fetch);
	}

	/**
	*	Retorna las filas afectadas por una sentencia
	*	@param integer ID de la sentencia
	*	@return integer Cantidad de registros afectados
	*/
	function sentencia_cantidad_afectados($id)
	{
		if(!isset($this->sentencias[$id]['id'])) {
			throw new toba_error("La sentencia solicitada no existe.");
		}
		return $this->sentencias[$id]['id']->rowCount();
	}
		
	//------------------------------------------------------------------------
	//------------ TRANSACCIONES ---------------------------------------------
	//------------------------------------------------------------------------
	
	/**
	 * Ejecuta un BEGIN TRANSACTION en la conexi�n
	 */
	function abrir_transaccion()
	{
		$this->conexion->beginTransaction();
		toba_logger::instancia()->debug("************ ABRIR transaccion ($this->base@$this->profile) ****************", 'toba');
	}

	/**
	 * Ejecuta un ROLLBACK en la conexi�n
	 */	
	function abortar_transaccion()
	{
		$this->conexion->rollBack();
		toba_logger::instancia()->debug("************ ABORTAR transaccion ($this->base@$this->profile) ****************", 'toba'); 
	}
	
	/**
	 * Ejecuta un COMMIT en la conexi�n
	 */		
	function cerrar_transaccion()
	{
		$this->conexion->commit();
		toba_logger::instancia()->debug("************ CERRAR transaccion ($this->base@$this->profile) ****************", 'toba'); 
	}

	/**
	*	Ejecuta un conjunto de comandos dentro de una transacci�n
	*	En caso de error en alg�n comando la aborta
	*	@param array $sentencias Conjunto de comandos sql
	*/
	function ejecutar_transaccion($sentencias_sql)
	{
		$sentencia_actual = 1;
		$this->abrir_transaccion();
		try {
			$this->ejecutar($sentencias_sql);
		} catch (exception_toba $e) {
			$this->abortar_transaccion();
			throw $e;
		}
		$this->cerrar_transaccion();
	}

	//------------------------------------------------------------------------

	/**
	 * Retorna el dsn necesario para conectar con PDO
	 * @return string
	 */
	function get_dsn()
	{
		throw new toba_error("No implementado para el motor: $this->motor");
	}

	/**
	 * Retorna el valor de un campo SERIAL
	 * @return string
	 */
	function recuperar_secuencia($secuencia)
	{
		throw new toba_error("No implementado para el motor: $this->motor");
	}

	/**
	 * Fuerza a que los chequeos de CONSTRAINTS de la transacci�n en curso se hagan al finalizar la misma

	 */
	function retrazar_constraints()
	{
		throw new toba_error("No implementado para el motor: $this->motor");
	}

	//------------------------------------------------------------------------
	//-- INSPECCION del MODELO de DATOS
	//------------------------------------------------------------------------
	
	function get_definicion_columnas($tabla)
	{
		throw new toba_error("No implementado para el motor: $this->motor");
	}
	
	/**
	*	Mapea un tipo de datos especifico de un motor a uno generico de toba
	*	Adaptado de ADOdb
	*/
	function get_tipo_datos_generico($tipo)
	{
		$tipo=strtoupper($tipo);
	static $typeMap = array(
		'VARCHAR' => 'C',
		'VARCHAR2' => 'C',
		'CHAR' => 'C',
		'C' => 'C',
		'STRING' => 'C',
		'NCHAR' => 'C',
		'NVARCHAR' => 'C',
		'VARYING' => 'C',
		'BPCHAR' => 'C',
		'CHARACTER' => 'C',
		'INTERVAL' => 'C',  # Postgres
		##
		'LONGCHAR' => 'X',
		'TEXT' => 'X',
		'NTEXT' => 'X',
		'M' => 'X',
		'X' => 'X',
		'CLOB' => 'X',
		'NCLOB' => 'X',
		'LVARCHAR' => 'X',
		##
		'BLOB' => 'B',
		'IMAGE' => 'B',
		'BINARY' => 'B',
		'VARBINARY' => 'B',
		'LONGBINARY' => 'B',
		'BYTEA' => 'B',
		'B' => 'B',
		##
		'YEAR' => 'F', // mysql
		'DATE' => 'F',
		'D' => 'F',
		##
		'TIME' => 'T',
		'TIMESTAMP' => 'T',
		'DATETIME' => 'T',
		'TIMESTAMPTZ' => 'T',
		'T' => 'T',
		##
		'BOOL' => 'L',
		'BOOLEAN' => 'L', 
		'BIT' => 'L',
		'L' => 'L',
		# SERIAL... se tratan como enteros#
		'COUNTER' => 'E',
		'E' => 'E',
		'SERIAL' => 'E', // ifx
		'INT IDENTITY' => 'E',
		##
		'INT' => 'E',
		'INT2' => 'E',
		'INT4' => 'E',
		'INT8' => 'E',
		'INTEGER' => 'E',
		'INTEGER UNSIGNED' => 'E',
		'SHORT' => 'E',
		'TINYINT' => 'E',
		'SMALLINT' => 'E',
		'E' => 'E',
		##
		'LONG' => 'N', // interbase is numeric, oci8 is blob
		'BIGINT' => 'N', // this is bigger than PHP 32-bit integers
		'DECIMAL' => 'N',
		'DEC' => 'N',
		'REAL' => 'N',
		'DOUBLE' => 'N',
		'DOUBLE PRECISION' => 'N',
		'SMALLFLOAT' => 'N',
		'FLOAT' => 'N',
		'FLOAT8' => 'N',
		'NUMBER' => 'N',
		'NUM' => 'N',
		'NUMERIC' => 'N',
		'MONEY' => 'N',
		
		## informix 9.2
		'SQLINT' => 'E', 
		'SQLSERIAL' => 'E', 
		'SQLSMINT' => 'E', 
		'SQLSMFLOAT' => 'N', 
		'SQLFLOAT' => 'N', 
		'SQLMONEY' => 'N', 
		'SQLDECIMAL' => 'N', 
		'SQLDATE' => 'F', 
		'SQLVCHAR' => 'C', 
		'SQLCHAR' => 'C', 
		'SQLDTIME' => 'T', 
		'SQLINTERVAL' => 'N', 
		'SQLBYTES' => 'B', 
		'SQLTEXT' => 'X' 
		);
		if(isset($typeMap[$tipo])) 
			return $typeMap[$tipo];
		return 'Z';
	}

	/**
	 * Dada una tabla retorna la SQL de carga de la tabla y sus campos cosm�ticos remontando referencias usando joins
	 * @param string $tabla
	 * @return array(sql, campo_clave, campo_descripcion)
	 */
	function get_sql_carga_tabla($tabla)
	{
		$columnas = $this->get_definicion_columnas($tabla);
		$claves = array();
		$select = array();
		$alias = sql_get_alias($tabla);		
		$from = array();
		$aliases = array($alias);
		$where = array();
		$left = array();
		$candidatos_descripcion = array();
		foreach ($columnas as $columna) {
			if ($columna['pk']) {
				$claves[] = $columna['nombre'];	
			}
			//-- Si es clave o no es una referencia se trae el dato puro
			if ($columna['pk']  || !$columna['fk_tabla']) {
				$select[] = $alias.'.'.$columna['nombre'];
				//-- Aprovecha para detectar el candidato a campo 'descripcion'
				if ($this->es_campo_candidato_descripcion($columna)) {
					$candidatos_descripcion[] = $columna['nombre'];
				}				
			} else {
				//--- Es una referencia, hay que hacer joins
				$externo = $this->get_opciones_sql_campo_externo($columna);
				$alias_externo = sql_get_alias( $externo['tabla']);
				if (in_array($alias_externo, $aliases)) {
					$alias_externo = $externo['tabla']; //En caso de existir el alias, usa el nombre de la tabla
				}
				$aliases[] = $alias_externo;
				if (isset($externo['descripcion'])) {				
					$columna_nombre = $columna['nombre'].'_nombre';
					$select[] = $alias_externo.'.'.$externo['descripcion'].' as '.$columna_nombre;
				}				
				$ext_where = $alias.'.'.$columna['nombre'].' = '.$alias_externo.'.'.$externo['clave'];
				$ext_from = $externo['tabla'].' as '.$alias_externo;
				if ($columna['not_null']) {
					//-- Si es NOT NULL, se hace un INNER join
					$from[] = $ext_from;
					$where[] = $ext_where;
				} else {
					//-- Si es NULL, se hace un LEFT OUTER join
					$left[] = "$ext_from ON ($ext_where)";
				}
			}
		}
		$campo_descripcion = $this->elegir_mejor_campo_descripcion($candidatos_descripcion);
		$from = array_unique($from);
		$sql = "SELECT\n\t".implode(",\n\t", $select);
		$sql .= "\nFROM\n\t$tabla as $alias";
		if (!empty($left)) {
			$texto_left = "\tLEFT OUTER JOIN ";
			$sql .= $texto_left.implode("\n$texto_left",$left);
		}
		if (!empty($from)) {
			$sql .= ",\n\t".implode(",\n\t",$from);	
		}
		if (!empty($where)) {
			$sql .= "\nWHERE\n\t\t".implode("\n\tAND  ",$where);
		}
		if (isset($campo_descripcion)) {
			$sql .= "\nORDER BY $campo_descripcion";
		}
		return array($sql, implode(',',$claves), $campo_descripcion);
	}
	
	/**
	 * Dada una tabla retorna la SQL que relaciona las claves con las descripciones
	 * @param string $tabla
	 * @return array(sql, campo_clave, campo_descripcion)
	 */	
	function get_sql_carga_descripciones($tabla)
	{
		$campos = $this->get_definicion_columnas($tabla);
		$encontrado = false;
		$candidatos_descripcion = array();
		$clave = null;
		foreach ($campos as $campo) {
			if ($campo['pk']) {
				$clave = $campo['nombre'];
			}
			if ($this->es_campo_candidato_descripcion($campo)) {
				$candidatos_descripcion[] = $campo['nombre'];
			}
		}
		$descripcion = $this->elegir_mejor_campo_descripcion($candidatos_descripcion);
		$sql = "SELECT $clave, $descripcion FROM $tabla ORDER BY $descripcion";
		return array($sql, $clave, $descripcion);
	}
		
	/**
	 * Determina la sql,clave y desc de un campo externo de una tabla
	 * Remonta N-niveles de indireccion de FKs
	 */
	function get_opciones_sql_campo_externo($campo)
	{
		$tablas_analizadas = array();
		//--- Busca cual es el campo descripcion de la tabla destino
		while (isset($campo['fk_tabla']) && ! in_array($campo['fk_tabla'], $tablas_analizadas)) {
			$tabla = $campo['fk_tabla'];
			$tablas_analizadas[] = $tabla;			
			$clave = $campo['fk_campo'];
			$descripcion = $campo['fk_campo'];
			//-- Busca cual es el campo descripci�n m�s 'acorde' en la tabla actual
			$campos_tabla_externa = $this->get_definicion_columnas($tabla);
			$encontrado = false;
			$candidatos_descripcion = array();
			//ei_arbol($campos_tabla_externa, $tabla);
			foreach ($campos_tabla_externa as $campo_tabla_ext) {
				//---Detecta cual es la clave para seguir ejecutando el script
				if ($campo_tabla_ext['nombre'] == $clave) {
					$campo = $campo_tabla_ext;
				}
				if ($this->es_campo_candidato_descripcion($campo_tabla_ext)) {
					$candidatos_descripcion[] = $campo_tabla_ext['nombre'];
				}
			}
			$descripcion = $this->elegir_mejor_campo_descripcion($candidatos_descripcion);
			if (! isset($descripcion)) {
				$descripcion = $clave;
			}
			$sql = "SELECT $clave, $descripcion FROM $tabla ORDER BY $descripcion";
		}
		return array('sql'=>$sql, 'tabla'=>$tabla, 'clave'=>$clave, 'descripcion'=>$descripcion);
	}	
	
	/**
	 * Determina si la definici�n de un campo de una tabla es un campo descripci�n
	 * @param array $campo Definicion de un campo
	 */
	protected function es_campo_candidato_descripcion($campo)
	{
		return !$campo['pk'] && ($campo['tipo'] == 'C' ||$campo['tipo'] == 'X');
	}
	
	/**
	 * Dado un conjunto de campos, escoje cual es el campo 'descripcion'
	 * @param unknown_type $campos
	 * @ignore
	 */
	protected function elegir_mejor_campo_descripcion($campos)
	{
		$mejor = null;
		$mejor_puntaje = 0;
		$puntajes = array('nombre' => 10, 'descripcion_corta'=> 9, 'descripcion'=> 8);	//Orden de preferencia
		foreach($campos as $campo) {
			if (isset($puntajes[$campo]) && $puntajes[$campo] > $mejor_puntaje) {
				$mejor = $campo;
				$mejor_puntaje = $puntajes[$campo];
			} else {
				if (! isset($mejor)) {
					$mejor = $campo;
				}
			}
		}
		return $mejor;
	}
	
	protected function cortar_sql($sql)
	{
		if (is_array($sql)){
			$sql = implode("\n", $sql);
		}
		if (strlen($sql) > 10000) {
			$sql = substr($sql, 0, 10000)."\n\n.... CORTADO POR EXCEDER EL LIMITE";
		}
		return $sql;
	}
	
	//-----------------------------------------------------------------------------------
	//-- GENERACION de MENSAJES de ERROR (Esto necesita adecuacion al esquema actual)
	//-----------------------------------------------------------------------------------

	/**
	*	Mapea el error de la base al modulo de mensajes del toba
	*/
	function get_error_toba($codigo, $descripcion)
	{
		throw new toba_error("No implementado para el motor: $this->motor");
	}
}
?>