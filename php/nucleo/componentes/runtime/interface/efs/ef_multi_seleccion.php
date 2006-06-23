<?php
require_once("ef.php");

abstract class ef_multi_seleccion extends ef
{
	protected $valores = array();
	protected $tamanio;
	protected $estado_nulo = array();
	protected $serializar = false;	
	protected $mostrar_utilidades;
		
	//parametros validaci�n
	protected $cant_maxima;
	protected $cant_minima;
	
	static function get_parametros()
	{
		$parametros = ef::get_parametros_carga();		
		$parametros["predeterminado"]["descripcion"]="Valor predeterminado";
		$parametros["predeterminado"]["opcional"]=1;	
		$parametros["predeterminado"]["etiqueta"]="Valor predeterminado";
		$parametros["dependencias"]["descripcion"]="El estado dependende de otro EF (CASCADA). Lista de EFs separada por comas";
		$parametros["dependencias"]["opcional"]=1;	
		$parametros["dependencias"]["etiqueta"]="Dependencias";		
		$parametros["dependencia_estricta"]["descripcion"]="Indica que las dependencias deben estar completas antes de cargar los datos";
		$parametros["dependencia_estricta"]["opcional"]=1;	
		$parametros["dependencia_estricta"]["etiqueta"]="Dep. estricta";		
		$parametros["cant_minima"]["descripcion"]="Cantidad Minima";
		$parametros["cant_minima"]["opcional"]=1;	
		$parametros["cant_minima"]["etiqueta"]="Cantidad Minima";
		$parametros["cant_maxima"]["descripcion"]="Cantidad M�xima";
		$parametros["cant_maxima"]["opcional"]=1;	
		$parametros["cant_maxima"]["etiqueta"]="Cantidad M�xima";			
		$parametros["solo_lectura"]["descripcion"]="Establece el elemento como solo lectura.";
		$parametros["solo_lectura"]["opcional"]=1;	
		$parametros["solo_lectura"]["etiqueta"]="Solo lectura";
		$parametros["mostrar_utilidades"]["descripcion"]="Permite que el usuario seleccione/deseleccione todos los elementos";
		$parametros["mostrar_utilidades"]["opcional"]=1;	
		$parametros["mostrar_utilidades"]["etiqueta"]="Utilidad 'Todos/Ninguno'";
		return $parametros;
	}

	function __construct($padre,$nombre_formulario, $id,$etiqueta,$descripcion,$dato,$obligatorio,$parametros)
	{
		parent::__construct($padre,$nombre_formulario, $id,$etiqueta,$descripcion,$dato,$obligatorio,$parametros);		
		if (isset($parametros['mostrar_utilidades'])) {
			$this->mostrar_utilidades = $parametros['mostrar_utilidades'];
		} else { 
			$this->mostrar_utilidades = false;
		}		
		if(isset($parametros["tamanio"])) {
			$this->tamanio = $parametros['tamanio'];
			unset($parametros['tamanio']);
		}
		if(isset($parametros["cant_maxima"])) {
			$this->cant_maxima = $parametros['cant_maxima'];
			unset($parametros['cant_maxima']);
		}
		if(isset($parametros["cant_minima"])) {
			$this->cant_minima = $parametros['cant_minima'];
			unset($parametros['cant_minima']);
		}
		if(isset($parametros["serializar"])) {
			$this->serializar = $parametros["serializar"];
		}
		
		//---------------------- Manejo de Estado por defecto  ------------------		
		if (isset($parametros["predeterminado"]) && $parametros["predeterminado"]!="") {
			$estados = explode(',', $parametros["predeterminado"]);
			$estados = array_map('trim', $estados);
			if (is_array($this->dato)) {
				$this->estado_defecto = array();
				$actual = 0;
				foreach ($estados as $estado) {
					$param = explode('/', $parametros["predeterminado"]);
					$parm = array_map('trim', $param);
					for ($i=0; $i < count($this->dato); $i++) {
						$this->estado_defecto[$actual][$this->dato[$i]] = trim($param[$i]);
					}
					$actual++;
				}
			} else {
				$this->estado_defecto = $estados;	
			}
		}		
		
		$this->estado_nulo = array();
		if (! isset($this->estado_defecto)) {
			$this->estado_defecto = $this->estado_nulo;
		}	
		$this->set_estado($this->estado_defecto);		
	}
	
	function activado()
	{
		return isset($this->estado) && !$this->es_estado_nulo($this->estado);
	}	
	
	function cargar_valores($datos)
	{
		if (!isset($datos)) {
			$datos = array();	
		}
		$this->valores = $datos;
	}
	
	protected function es_estado_individual_nulo($estado)
	{
		if (is_array($this->dato)) {
			if ($estado === null) {
				return true;	
			}
			//Si el estado es nulo tengo que manejarlo de una forma especial
			$valores = "";
			foreach ($estado as $valor) {
				$valores .= $valor;
			}		
			return trim($valores) === '';
		} else {
			return $estado === null;	
		}
	}
	
	protected function es_estado_nulo($estado)
	{
		if (!isset($estado)) {
			return true;	
		}
		if (is_array($estado) && empty($estado)) {
			return true;	
		}
		return false;
	}

	protected function validar_estado_particular($estado)
	{
		if (is_array($this->dato)) {
			//Maneja multiples datos
			//El estado tiene el formato adecuado?
			$cant_datos = count($this->dato);
			if (count($estado) <> $cant_datos) {
				throw new excepcion_toba("Ha intentado cargar el combo '{$this->id}' con un array que posee un formato inadecuado " .
								" se esperaban {$cant_datos} claves, pero se utilizaron: ". count($estado) . ".");
			}
		}								
	}
	
	function set_estado($estado)
	{
		if ($this->serializar !== false) {
			$estado = explode($this->serializar, $estado);
		}
		if ($this->es_estado_nulo($estado)) {
			$this->estado = $this->estado_nulo;
		} else {
			foreach ($estado as $elem) {
				$this->validar_estado_particular($elem);
			}
			$this->estado = $estado;
		}
	}
	
	function cargar_estado_post()
	{
		if (! isset($_POST[$this->id_form])) {
			$this->estado = $this->estado_nulo;
			return false;
		}
		if (is_array($this->dato)) {
			$estado = $_POST[$this->id_form];
			$cant_datos = count($this->dato);
			$this->estado = array();
			foreach ($estado as $seleccion) {
	            $valores = explode(apex_ef_separador, $seleccion);
				if (count($valores) <> $cant_datos) {
					throw new excepcion_toba("Ha intentado cargar el ef '{$this->id}' con un array que posee un formato inadecuado " .
									" se esperaban {$cant_datos} claves, pero se utilizaron: ". count($valores) . ".");
				}
				$nuevo = array();
				for ($i=0; $i < count($this->dato); $i++) {
				   	$nuevo[$this->dato[$i]] = $valores[$i];
				}
				$this->estado[] = $nuevo;
			}
		} else {
			parent::cargar_estado_post();
		}
		return true;
	}

    function validar_estado()
    {
		$padre = parent::validar_estado();
		if ($padre !== true) {
			return $padre;	
		}
		if (isset($this->cant_minima)) { 
			if (count($this->estado) < $this->cant_minima){
				$elemento = ($this->cant_minima == 1) ? "un elemento" : "{$this->cant_minima} elementos";
                return "Seleccione al menos $elemento.";
			}
		}
		if (isset($this->cant_maxima)){ 
			if (count($this->estado) > $this->cant_maxima){
				$elemento = ($this->cant_maxima == 1) ? "un elemento" : "{$this->cant_maxima} elementos";				
                return "No puede seleccionar m�s de $elemento.";
			}
		}
		return true;
    }
	
	protected function parametros_js()
	{
		$limites = array();
		$limites[0] = isset($this->cant_minima) ? $this->cant_minima : null;
		$limites[1] = isset($this->cant_maxima) ? $this->cant_maxima : null;
		return parent::parametros_js().','.js::arreglo($limites, false);
	}
	
	function es_seleccionable()
	{
		return true;	
	}
	
	function es_estado_unico() 
	{
		return false;	
	}	
	
	function get_consumo_javascript()
	{
		$consumos = array('interface/ef', 'interface/ef_multi_seleccion');
		return $consumos;
	}
		
	function get_descripcion_estado()
	{
		$desc = "<ul>\n";
		foreach ($this->get_estado_para_input() as $estado) {
			$desc .= "<li>{$this->valores[$estado]}</li>\n";
		}
		$desc .= "</ul>\n";
		return $desc;	
	}
	
	function get_estado()
	{
		if ($this->activado()) {
			if ($this->serializar !== false) {
				return implode($this->estado, $this->serializar);	
			} else {
				return $this->estado;
			}
		} else {
			if ($this->serializar !== false) {
				return null;	
			} else {
				return array();
			}
		}		
	}
	
	function get_valores()
	{
		return $this->valores;
	}	
	
	protected function get_estado_para_input()
	{
		if ($this->es_estado_nulo($this->estado))	{
			return $this->estado_nulo;	
		}
		if (! is_array($this->dato)) {
			return $this->estado;	
		} else {
			$salida = array();
			foreach ($this->estado as $registro) {
				$salida[] = implode(apex_ef_separador, $registro);
			}	
			return $salida;
		}
	}
	
	
}

//########################################################################################################
//########################################################################################################

class ef_multi_seleccion_lista extends ef_multi_seleccion
{
	
	static function get_parametros()
	{
		$parametros = ef_multi_seleccion::get_parametros();
		$parametros["tamanio"]["descripcion"]="Cantidad de elementos que se visualizan simult�neamente";
		$parametros["tamanio"]["opcional"]=1;	
		$parametros["tamanio"]["etiqueta"]="Tama�o";			
		return $parametros;
	}

	function __construct($padre,$nombre_formulario, $id,$etiqueta,$descripcion,$dato,$obligatorio,$parametros)
	{
		parent::__construct($padre,$nombre_formulario, $id,$etiqueta,$descripcion,$dato,$obligatorio,$parametros);		
	}

	function get_input()
	{
		$estado = $this->get_estado_para_input();
		$html = "";
		if (!$this->solo_lectura && $this->mostrar_utilidades)	{
			$html .= "
				<div class='ef-multi-sel-todos' id='{$this->id_form}_utilerias'>
					<a href=\"javascript:{$this->objeto_js()}.seleccionar_todo(true)\">Todos</a> / 
					<a href=\"javascript:{$this->objeto_js()}.seleccionar_todo(false)\">Ninguno</a></div>
			";
		}
		$tamanio = isset($this->tamanio) ? $this->tamanio: count($this->valores);
		$extra = ($this->solo_lectura) ? "disabled" : "";
		$html .= form::multi_select($this->id_form, $estado, $this->valores, $tamanio, 'ef-combo', $extra);
		return $html;
	}
	
	function crear_objeto_js()
	{
		return "new ef_multi_seleccion_lista({$this->parametros_js()})";
	}	
	
}
//########################################################################################################
//########################################################################################################

class ef_multi_seleccion_check extends ef_multi_seleccion
{
	
	function crear_objeto_js()
	{
		return "new ef_multi_seleccion_check({$this->parametros_js()})";
	}	
	
	function get_input()
	{
		$estado = $this->get_estado_para_input();
		$html = "";
		if ($this->solo_lectura) {
			$html .= "<div id='{$this->id_form}_opciones' style='clear:both'>";
			foreach ($this->valores as $id => $descripcion) {
				$html .= "<label class='ef-multi-check'>";
				if (in_array($id, $estado)) {
					$html .= recurso::imagen_apl('checked.gif',true,16,16);
				} else  {
					$html .= recurso::imagen_apl('unchecked.gif',true,16,16);
				}
				$html .= "$descripcion</label>\n";
			}
			$html .= "</div>";			
		} else {
			if ($this->mostrar_utilidades)	{
				$html .= "
					<div id='{$this->id_form}_utilerias' class='ef-multi-sel-todos'>
						<a href=\"javascript:{$this->objeto_js()}.seleccionar_todo(true)\">Todos</a> / 
						<a href=\"javascript:{$this->objeto_js()}.seleccionar_todo(false)\">Ninguno</a></div>
				";
			}		
			$html .= "<div id='{$this->id_form}_opciones'>";
			$i =0;
			foreach ($this->valores as $clave => $descripcion) {
				$id = $this->id_form.$i;
				$checkeado = in_array($clave, $estado) ? "checked" : "";
				$html .= "<label class='ef-multi-check' for='$id'>";
				$html .= "<input name='{$this->id_form}[]' id='$id' type='checkbox' value='$clave' $checkeado class='ef-checkbox'>";
				$html .= "$descripcion</label>\n";
				$i++;
			}
			$html .= "</div>";
		}
		return $html;
	}	
	
}

//########################################################################################################
//########################################################################################################


class ef_multi_seleccion_doble extends ef_multi_seleccion
{
	protected function parametros_js()
	{
		$imgs = array();
		$imgs[] = recurso::imagen_apl('paginacion/no_siguiente.gif', false);
		$imgs[] = recurso::imagen_apl('paginacion/si_siguiente.gif', false);
		$imgs[] = recurso::imagen_apl('paginacion/no_anterior.gif', false);
		$imgs[] = recurso::imagen_apl('paginacion/si_anterior.gif', false);
		return parent::parametros_js().",".js::arreglo($imgs, false);
	}
	
	function crear_objeto_js()
	{
		return "new ef_multi_seleccion_doble({$this->parametros_js()})";
	}	
		
	function get_input()
	{
		$html = '';
		$tamanio = isset($this->tamanio) ? $this->tamanio: count($this->valores);
		$estado = $this->get_estado_para_input();
		$izq = array();
		$der = array();
		foreach ($this->valores as $clave => $valor) {
			if (in_array($clave, $estado)) {
				$der[$clave] = $valor;	
			} else {
				$izq[$clave] = $valor;	
			}
		}	
		$etiq_izq = "Disponibles";
		$etiq_der = "Seleccionados";
		$ef_js = $this->objeto_js();
		$img_der = recurso::imagen_apl('paginacion/no_siguiente.gif', false);
		$boton_der = "<img src='$img_der' id='{$this->id_form}_img_izq' onclick=\"$ef_js.pasar_a_derecha()\" class='ef-multi-doble-boton'>";
		$img_izq = recurso::imagen_apl('paginacion/no_anterior.gif', false);
		$boton_izq = "<img src='$img_izq' id='{$this->id_form}_img_der' onclick=\"$ef_js.pasar_a_izquierda()\" class='ef-multi-doble-boton'>";
		
		$disabled = ($this->solo_lectura) ? "disabled" : "";
		$html .= "<table style='font-weight:normal;'>";
		$html .= "<tr><td>$etiq_izq</td><td></td><td>$etiq_der</td></tr>";
		$html .= "<tr><td>";
		$html .= form::multi_select($this->id_form."_izq", array(), $izq, $tamanio, 'ef-combo', "$disabled ondblclick=\"$ef_js.pasar_a_derecha();\" onchange=\"$ef_js.refrescar_iconos('izq');\"");
		$html .= "</td><td>$boton_der<br><br>$boton_izq</td><td>";
		$html .= form::multi_select($this->id_form, array(), $der, $tamanio, 'ef-combo', "$disabled ondblclick=\"$ef_js.pasar_a_izquierda();\" onchange=\"$ef_js.refrescar_iconos('der');\"");		
		$html .= "</td></tr>";
		$html .= "</table>";
		return $html;
	}

}

?>