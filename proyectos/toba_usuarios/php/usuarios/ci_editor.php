<?php

class ci_editor extends toba_ci
{	
	const clave_falsa = "xS34Io9gF2JD";					//La clave no se envia al cliente
	
	protected $s__proyecto;
	protected $s__usuario;

	function datos($tabla)
	{
		return	$this->controlador->dep('datos')->tabla($tabla);
	}
	
	function limpiar_datos()
	{
		unset($this->s__proyecto);
	}
	
	function conf()
	{
		if ($this->controlador()->dep('datos')->esta_cargada()) {
			$usuario = $this->datos('basica')->get();
			$this->s__usuario = $usuario['usuario'];
			$desc = 'Usuario: <strong>' . texto_plano($usuario['nombre']) . '</strong>';
			$this->pantalla()->set_descripcion($desc);
			$this->dep('basica')->ef('usuario')->set_solo_lectura(true);
		} else {
			$this->controlador->pantalla()->eliminar_evento('eliminar');
		}
	}
	
	function conf__proyecto()
	{
		if (!isset($this->s__proyecto)) {
			$this->pantalla('proyecto')->eliminar_dep('form_proyectos');	
		}
	}

	//---- Info BASICA -------------------------------------------------------

	function evt__basica__modificacion($datos)
	{
		if ($datos['clave'] == self::clave_falsa ) {
			unset($datos['clave']);	
		}
		$this->datos('basica')->set($datos);
	}

	function conf__basica()
	{
		$datos = $this->datos('basica')->get();
		if (isset($datos)) {
			$datos['clave'] = self::clave_falsa;
		}
		return $datos;
	}

	//---- Asociacion a PROYECTOS -------------------------------------------------

	function evt__proyecto__salida()
	{
		$this->datos('proyecto')->resetear_cursor();		
	}

	function evt__cuadro_proyectos__seleccion($seleccion)
	{
		$this->s__proyecto = $seleccion['proyecto'];
	}
	
	function conf__cuadro_proyectos($componente)
	{	
		$proyectos = consultas_instancia::get_lista_proyectos();
		foreach ($proyectos as $id => $proyecto){
			$grupos_acceso = $this->datos('proyecto')->get_filas(array('proyecto' => $proyecto['proyecto']));
			$grupos = array();
			//-- Perfil funcional -------------------------
			foreach ($grupos_acceso as $ga){
				$grupos[] = $ga['grupo_acceso'];
			}
			$proyectos[$id]['grupos_acceso'] = empty($grupos) ? '-- Sin Acceso --' : implode(', ', $grupos);
			//-- Perfil datos -----------------------------
			$perfil_datos = $this->datos('proyecto_pd')->get_filas(array('proyecto' => $proyecto['proyecto']));
			if($perfil_datos){
				$proyectos[$id]['perfil_datos'] = $perfil_datos[0]['perfil_datos_nombre'];
			} else {
				$proyectos[$id]['perfil_datos'] = '&nbsp;';
			}
		}
		$componente->set_datos($proyectos);
	}

	function evt__form_proyectos__modificacion($datos)
	{
		if (isset($datos['clave']) && $datos['clave'] == self::clave_falsa ) {
			unset($datos['clave']);	
		}
		//-- Perfil funcional -------------------------
		$id = $this->datos('proyecto')->get_id_fila_condicion(array('proyecto'=>$this->s__proyecto));
		foreach ($id as $clave){
			$this->datos('proyecto')->eliminar_fila($clave);
		}
		$fila = array();
		$fila['proyecto'] = $this->s__proyecto;
		$fila['usuario'] = $this->s__usuario;
		foreach ($datos['usuario_grupo_acc'] as $id=>$grupo_acceso){
			$fila['usuario_grupo_acc'] = $grupo_acceso;
			$this->datos('proyecto')->nueva_fila($fila);
		}
		//-- Perfil datos -----------------------------
		$id = $this->datos('proyecto_pd')->get_id_fila_condicion(array('proyecto'=>$this->s__proyecto));
		if ( isset($datos['usuario_perfil_datos']) ) {
			$fila = array();
			$fila['proyecto'] = $this->s__proyecto;
			$fila['usuario'] = $this->s__usuario;
			$fila['usuario_perfil_datos'] = $datos['usuario_perfil_datos'];
			if(empty($id)) {
				$this->datos('proyecto_pd')->nueva_fila($fila);
			}else{
				$this->datos('proyecto_pd')->modificar_fila($id[0], $fila);
			}
		} else if (! empty($id)) {
			//-- Si por pantalla no viene nada pero esta en la tabla hay que borrarlo
			$this->datos('proyecto_pd')->eliminar_fila($id[0]);
		}
		$this->limpiar_datos();
	}

	function evt__form_proyectos__baja()
	{
		//-- Perfil funcional -------------------------
		$id = $this->datos('proyecto')->get_id_fila_condicion( array('proyecto' => $this->s__proyecto) );
		foreach ($id as $clave){
			$this->datos('proyecto')->eliminar_fila($clave);
		}
		//-- Perfil datos -----------------------------
		$id = $this->datos('proyecto_pd')->get_id_fila_condicion(array('proyecto'=>$this->s__proyecto));
		if(!empty($id)) {
			$this->datos('proyecto_pd')->eliminar_fila($id[0]);
		}
		$this->limpiar_datos();
	}
	
	function evt__form_proyectos__cancelar()
	{
		unset($this->s__proyecto);
	}
	
	function conf__form_proyectos($componente)
	{
		if (isset($this->s__proyecto)) {
			$datos = array();
			$datos['proyecto'] = $this->s__proyecto;
			$datos['clave'] = self::clave_falsa;
			//-- Perfil funcional -------------------------
			$grupo_acc = $this->datos('proyecto')->get_filas( array('usuario'=> $this->s__usuario, 'proyecto'=>$this->s__proyecto));
			if (empty($grupo_acc)) {
				$componente->eliminar_evento('baja');
			}
			
			$ga_seleccionados = array();
			foreach ($grupo_acc as $i=>$ga){
				$ga_seleccionados[] = $ga['usuario_grupo_acc'];
			}
			$datos['usuario_grupo_acc'] = $ga_seleccionados;
			//-- Perfil datos -----------------------------
			$perfil_datos = $this->datos('proyecto_pd')->get_filas(array('usuario'=> $this->s__usuario, 'proyecto'=>$this->s__proyecto));
			if($perfil_datos){
				$datos['usuario_perfil_datos'] = $perfil_datos[0]['usuario_perfil_datos'];
			}
			$componente->set_datos($datos);
		}
	}
		
	//---- Consultas ---------------------------------------------------
	
	function get_lista_grupos_acceso_proyecto()
	{
		$sql = "SELECT 	usuario_grupo_acc,
						nombre,
						descripcion
				FROM 	apex_usuario_grupo_acc
				WHERE 	proyecto = '{$this->s__proyecto}';";
		return toba::db()->consultar($sql);
	}
	
}
?>