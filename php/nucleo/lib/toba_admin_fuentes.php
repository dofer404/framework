<?php
require_once('nucleo/lib/toba_fuente_datos.php');	
require_once('nucleo/lib/toba_dba.php');

/**
 * Colecci�n de Fuentes de Datos (toba_fuente_datos)
 * @package Fuentes
 */
class toba_admin_fuentes
{
	static private $instancia;
	private $fuentes;
	
	/**
	 * @return toba_admin_fuentes
	 */
	static function instancia()
	{
		if (!isset(self::$instancia)) {
			self::$instancia = new toba_admin_fuentes();
		}
		return self::$instancia;		
	}
	
	private function __construct() {}
	
	/**
	 * Retorna el nombre de la fuente marcada en el editor como predeterminada
	 * @param boolean $obligatorio Tira una excepci�n en caso de no existir
	 * @return string
	 */
	function get_fuente_predeterminada($obligatorio=false)
	{
		$predeterminada = toba::proyecto()->get_parametro('fuente_datos');	
		if( !($predeterminada) && $obligatorio ) {
			throw new toba_error('No existe una fuente de datos predeterminada');
		}
		return $predeterminada;
	}
	
	/**
	 * Retorna una fuente de datos
	 *
	 * @param string $id Id. de la fuente
	 * @param string $proyecto Proyecto al que pertenece la fuente
	 * @return toba_fuente_datos
	 */
	function get_fuente($id, $proyecto=null)
	{
		if(!isset($id)) {
			$id = $this->get_fuente_predeterminada(true);	
		}
		if ( !isset($this->fuentes[$id]) ) {
			$parametros = toba_proyecto::get_info_fuente_datos($id, $proyecto);
			if (isset($parametros['subclase_archivo'])) {
				$archivo = $parametros['subclase_archivo'];
			} else {
				$archivo = "nucleo/lib/toba_fuente_datos.php";
			}
			if (isset($parametros['subclase_nombre'])) {
				$clase = $parametros['subclase_nombre'];
			} else {
				$clase = "toba_fuente_datos";
			}		
			require_once($archivo);
			$this->fuentes[$id] = new $clase($parametros);
		}
		return $this->fuentes[$id];
	}
}
?>
