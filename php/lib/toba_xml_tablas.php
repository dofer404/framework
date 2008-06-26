<?php

class toba_xml_tablas
{
	protected $archivo;
	
	/**
	 * @var DOMDocument
	 */
	protected $xml;
	
	function __construct($archivo=null) {
		if (isset($archivo)) {
			$this->archivo = $archivo;
		} else {
			$this->xml = new DOMDocument('1.0','UTF-8');
			$this->xml->formatOutput = true;
		}
	}
	
	/**
	 * Carga el xml con un nodo por cada tabla, uno por cada registro y dentro uno por cada propiedad
	 * <tablas>
	 * 	 <$tabla>
	 * 		<fila>
	 * 			<$campo>$valor</$campo>
	 */
	function set_tablas($arreglo, $nombre='tablas', $nodo_raiz=null) {
		if (! isset($nodo_raiz)) {
			$nodo_raiz = $this->xml;
		}
		if (! is_int($nombre)) {
			$nombre = utf8_encode($nombre);
		} else {
			$nombre = 'fila';
		}
		$actual = $nodo_raiz->appendChild($this->xml->createElement($nombre));
		
		foreach ($arreglo as $clave => $valor) {
			if (is_array($valor)) {
				//--Acceso recursivo para los registros o composici�n de tablas
				$this->set_tablas($valor, $clave, $actual);
			} else {
				$valor = utf8_encode($valor);
				$clave = utf8_encode($clave);
				$actual->appendChild($this->xml->createElement($clave, $valor));
			}			
		}
	}
	
	/**
	 * Retorna un arreglo asociativo por nombre de tabla conteniendo dentro un recordset
	 * 	
	 *	$tablas = array(
	 * 		'tabla' => array(
	 * 				0 => array('campo' => 'valor', ..)
	 * 
	 */
	function get_tablas()
	{
		$datos = simplexml_load_file($this->archivo);
		$salida = array();
		foreach ($datos as $tabla => $filas) {
			$tabla = utf8_decode($tabla);
			$salida[$tabla] = array();
			foreach ($filas as $fila) {
				$registro = array();
				$vars = get_object_vars($fila);
				foreach ($vars as $clave => $valor) {
					$valor = utf8_decode(strval($valor));
					if ($valor === '') {
						$valor = null;
					}
					$registro[utf8_decode($clave)] = $valor;
				}
				$salida[$tabla][] = $registro;				
			}

		}
		return $salida;
	}
	
	/**
	 * Dada la informaci�n contenida en el xml intenta insertar los datos en una base
	 * En caso de falla, se sigue adelante en la transacci�n utilizando SAVEPOINTs (postgres>=8.0)
	 */
	function insertar_db(toba_db $conexion)
	{
		$conexion->retrazar_constraints(false);
		$tablas = $this->get_tablas();
		$errores = array();
		$i = 0;
		//-- Recorre cada tabla
		foreach ($tablas as $tabla => $filas) {
			//-- Recorre cada fila
			foreach ($filas as $fila) {
				try {
					//Guarda un savepoint por si falla la ejecucion
					$conexion->ejecutar('SAVEPOINT toba_'.$i);
					$sql = sql_array_a_insert($tabla, $fila);
					$conexion->ejecutar($sql);
					//Si no falla se libera el savepoint
					$conexion->ejecutar('RELEASE SAVEPOINT toba_'.$i);
				} catch (toba_error_db $e) {
					//Al fallar se vuelve al estado anterior del fallo
					$conexion->ejecutar('ROLLBACK TO SAVEPOINT toba_'.$i);
					$errores[] = array('tabla' 		=> $tabla,
										'sql'		=> $sql, 
										'datos' 	=> $fila, 
										'msg_motor' => $e->get_mensaje_motor(), 
										'msg_toba' 	=> $e->get_mensaje(),
										);
				}
				$i++;
			}
		}
		$conexion->retrazar_constraints(false);
		return $errores;
	}

	
	function guardar($archivo)
	{
		$this->xml->save($archivo);
	}
	
	function get_xml()
	{
		return $this->xml;
	}
	
}


?>