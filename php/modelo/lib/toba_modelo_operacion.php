<?php

/**
 * Clase que permite manipular como un todo a c�digo y metadatos vinculados a una operaci�n
 */
class toba_modelo_operacion
{
	protected $arbol;
	protected $id_proyecto;
	protected $id_item;
	
	function __construct($proyecto, $item)
	{
		$this->id_proyecto = $proyecto;
		$this->id_item = $item;
		$this->arbol = toba_info_editores::get_arbol_componentes_item($proyecto, $item);
	}
	
	function hay_componentes_eliminar()
	{
		return count($this->arbol) > 1;
	}
	
	function get_info_eliminacion()
	{
		$datos = array();
		$a=0;
		$arbol_componentes = array_slice($this->arbol,1);

		foreach( $arbol_componentes as $arbol ) {
			$img = '';
			$txt_archivo = '';
			$txt_consumo = '';
			$tip = "<strong>Tipo</strong>: {$arbol['tipo']}<br><strong>Nombre</strong>: {$arbol['nombre']}";
			$datos[$a]['tipo'] = $arbol['tipo'];
			$datos[$a]['clase'] = toba_recurso::imagen_toba($arbol['icono'], true, null, null, $tip);
			$datos[$a]['componente'] = $arbol['componente'];
			$datos[$a]['consumidores_externos'] =  $arbol['consumidores_externos'];
			if(isset($arbol['subclase'])) {
				$datos[$a]['posee_subclase'] = toba_recurso::imagen_toba('aplicar.png', true);
				$img = 'info_chico.gif';
				$txt_archivo = "</hr>Atencion: el componente posee asociada la subclase <strong>{$arbol['subclase']}</strong> en el archivo <strong>{$arbol['subclase_archivo']}</strong>.";
			} else {
				$datos[$a]['posee_subclase'] = '';
			}
			if($arbol['consumidores_externos']>0) {
				$img = 'warning.gif';
				$txt_archivo = "</hr>Atencion: el componente esta siendo consumido por otros componentes [<strong>referencias: {$arbol['consumidores_externos']}</strong>].";
				$datos[$a]['eliminar'] = 0;
				$datos[$a]['eliminar_archivo'] = 0;
			} else {
				$datos[$a]['eliminar'] = 1;
				$datos[$a]['eliminar_archivo'] = 1;
			}
			if($img) {
				$datos[$a]['info'] = toba_recurso::imagen_toba($img, true, null, null, $txt_archivo . $txt_consumo);
			}
			$a++;
		}
		return $datos;
	}

	/**
	 * Elimina opcionalmente un conjunto de componentes pertencientes a la operaci�n
	 *
	 * @param boolean $borrar_item Debe borrar el item una vez borradas sus dependencias
	 * @param array $opciones Arreglo 'id_componente' => array('eliminar'=>true/false, 'eliminar_archivo'=>true/false)
	 * @param boolean $con_transaccion Debe enmarcar la eliminaci�n en una transaccion
	 */
	function eliminar($borrar_item, $opciones, $con_transaccion=true)
	{
		$item = toba::zona()->get_info();
		$db = toba_contexto_info::get_db();
		$arbol_componentes = array_slice($this->arbol,1);		

		//--- Se eliminan metadatos		
		if ($con_transaccion) {
			$db->abrir_transaccion();			
		}
		foreach ($arbol_componentes as $comp) {
			$opcion = $opciones[$comp['componente']];
			if ($opcion['eliminar']) {
				//--- Elimina metadatos
				$id_dr = toba_info_editores::get_dr_de_clase($comp['tipo']);
				$componente = array('proyecto' => $id_dr[0], 'componente' => $id_dr[1]);
				$dr = toba_constructor::get_runtime($componente, 'toba_datos_relacion', false);
				$dr->get_persistidor()->desactivar_transaccion();
				$dr->resetear();
				$dr->cargar(array('proyecto' => $this->id_proyecto, 'objeto' => $comp['componente']));
				$dr->eliminar_todo();
			}
		}
		//--Borro el item		
		if ($borrar_item) {
			$id_dr = toba_info_editores::get_dr_de_clase('toba_item');
			$componente = array('proyecto' => $id_dr[0], 'componente' => $id_dr[1]);
			$dr = toba_constructor::get_runtime($componente, 'toba_datos_relacion', false);
			$dr->get_persistidor()->desactivar_transaccion();
			$dr->resetear();
			$dr->cargar(array('proyecto' => $this->id_proyecto, 'item' => $this->id_item));
			$dr->eliminar_todo();
		}
		if ($con_transaccion) {
			$db->cerrar_transaccion();					
		}		
		//--- Se eliminan subclases
		foreach ($arbol_componentes as $comp) {
			$opcion = $opciones[$comp['componente']];			
			if ($opcion['eliminar'] && $opcion['eliminar_archivo']) {
				$archivo = $comp['subclase_archivo'];
				$archivo = toba_instancia::get_path_proyecto($this->id_proyecto).'/php/'.$archivo;
				unlink($archivo);
			}			
		}		
	}	
	
	
}

?>