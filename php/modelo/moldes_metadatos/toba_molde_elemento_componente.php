<?php
/*
*	
*/
class toba_molde_elemento_componente extends toba_molde_elemento
{
	protected $clase_proyecto ='toba';
	protected $subclase;
	protected $molde_php = null;					// Clase molde de codigo PHP
	protected $chequear_opcion_pisar_archivo = false;
	
	function ini()
	{
		$this->datos->tabla('base')->set_fila_columna_valor(0,'clase',$this->clase);
		$this->datos->tabla('base')->set_fila_columna_valor(0,'clase_proyecto',$this->clase_proyecto);
	}
	
	//---------------------------------------------------
	//-- Extension de clases
	//---------------------------------------------------	

	/**
	*	Declara la extension del archivo, despues de su invocacion se puede usar
	*	el metodo php() para acceder al molde de la clase
	*/
	function extender($subclase, $archivo)
	{
		if(!isset($this->molde_php)) {
			$this->subclase = $subclase;
			$this->archivo = $archivo;
			$this->carpeta_archivo = $this->asistente->get_carpeta_archivos();
			$this->molde_php = new toba_codigo_clase( $this->subclase, $this->clase );
			//Dejo la marca
			if( file_exists($this->archivo_absoluto()) ) {
				$txt = "Reemplazar archivo: " . $this->archivo_relativo();
				$ayuda = "Si no desea reemplazar el archivo, modifique el molde especificando otra carpeta de destino u otro prefijo para la generacion de clases.";
				$this->asistente->agregar_opcion_generacion( $this->get_id_opcion_archivo(), $txt, $ayuda );
				$this->chequear_opcion_pisar_archivo = true;
			}
		}
	}

	function php()
	{
		return $this->molde_php;	
	}
	
	function generar_archivo()
	{
		if ($this->chequear_opcion_pisar_archivo) {
			if( $this->asistente->consultar_opcion_generacion($this->get_id_opcion_archivo()) ) {
				return parent::generar_archivo();
			} else {
				return false;	
			}
		} else {
			return parent::generar_archivo();
		}	
	}
	
	//---------------------------------------------------
	//-- Generacion de METADATOS & ARCHIVOS
	//---------------------------------------------------	

	protected function get_codigo_php()
	{
		return $this->molde_php->get_codigo();	
	}

	protected function asociar_archivo()
	{
		$this->datos->tabla('base')->set_fila_columna_valor(0,'subclase',$this->subclase);
		$this->datos->tabla('base')->set_fila_columna_valor(0,'subclase_archivo',$this->archivo_relativo());
	}
	
	function get_clave_componente_generado()
	{
		$datos = $this->datos->tabla('base')->get_clave_valor(0);
		return array(	'clave' => $datos['objeto'],
						'proyecto' => $datos['proyecto']);
	}
}
?>