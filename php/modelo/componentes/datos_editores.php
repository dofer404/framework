<?

class datos_editores
{
	static function get_pantallas_objeto_ei_arbol()
	{
		return array (
  0 => 
  array (
    'identificador' => 'basicas',
    'etiqueta' => 'Propiedades B�sicas',
    'imagen' => 'objetos/arbol.gif',
  ),
);
	}

	static function get_pantallas_objeto_cn()
	{
		return array (
  0 => 
  array (
    'identificador' => 'basicas',
    'etiqueta' => 'Propiedades B�sicas',
    'imagen' => 'objetos/negocio.gif',
  ),
  1 => 
  array (
    'identificador' => 'pant_dependencias',
    'etiqueta' => 'Dependencias',
    'imagen' => 'objetos/asociar_objeto.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_calendario()
	{
		return array (
  0 => 
  array (
    'identificador' => 'basicas',
    'etiqueta' => 'Propiedades B�sicas',
    'imagen' => 'objetos/calendario.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_esquema()
	{
		return array (
  0 => 
  array (
    'identificador' => 'basicas',
    'etiqueta' => 'Propiedades B�sicas',
    'imagen' => 'objetos/esquema.gif',
  ),
  1 => 
  array (
    'identificador' => 'p_eventos',
    'etiqueta' => 'Eventos',
    'imagen' => 'reflexion/evento.gif',
  ),
);
	}

	static function get_pantallas_objeto_ci()
	{
		return array (
  0 => 
  array (
    'identificador' => '0',
    'etiqueta' => 'Propiedades Basicas',
    'imagen' => 'objetos/multi_etapa.gif',
  ),
  1 => 
  array (
    'identificador' => '1',
    'etiqueta' => 'Dependencias',
    'imagen' => 'objetos/asociar_objeto.gif',
  ),
  2 => 
  array (
    'identificador' => '2',
    'etiqueta' => 'Pantallas',
    'imagen' => 'objetos/pantalla.gif',
  ),
  3 => 
  array (
    'identificador' => '3',
    'etiqueta' => 'Eventos',
    'imagen' => 'reflexion/evento.gif',
  ),
);
	}

	static function get_pantallas_objeto_datos_tabla()
	{
		return array (
  0 => 
  array (
    'identificador' => '1',
    'etiqueta' => 'Propiedades basicas',
    'imagen' => 'objetos/datos_tabla.gif',
  ),
  1 => 
  array (
    'identificador' => '2',
    'etiqueta' => 'Columnas',
    'imagen' => 'objetos/columna.gif',
  ),
  2 => 
  array (
    'identificador' => '3',
    'etiqueta' => 'Carga externa',
    'imagen' => 'objetos/carga_externa.png',
  ),
);
	}

	static function get_pantallas_objeto_datos_relacion()
	{
		return array (
  0 => 
  array (
    'identificador' => 'p_prop_basicas',
    'etiqueta' => 'Propiedades basicas',
    'imagen' => 'objetos/datos_relacion.gif',
  ),
  1 => 
  array (
    'identificador' => 'p_tablas',
    'etiqueta' => 'Tablas',
    'imagen' => 'objetos/datos_tabla.gif',
  ),
  2 => 
  array (
    'identificador' => 'p_relaciones',
    'etiqueta' => 'Relaciones',
    'imagen' => 'objetos/relaciones.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_archivos()
	{
		return array (
  0 => 
  array (
    'identificador' => '0',
    'etiqueta' => 'Propiedades B�sicas',
    'imagen' => 'objetos/archivos.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_cuadro()
	{
		return array (
  0 => 
  array (
    'identificador' => '1',
    'etiqueta' => 'Propiedades basicas',
    'imagen' => 'objetos/cuadro_array.gif',
  ),
  1 => 
  array (
    'identificador' => '2',
    'etiqueta' => 'Columnas',
    'imagen' => 'objetos/columna.gif',
  ),
  2 => 
  array (
    'identificador' => 'pant_cortes',
    'etiqueta' => 'Cortes Control',
    'imagen' => 'objetos/fila.gif',
  ),
  3 => 
  array (
    'identificador' => '3',
    'etiqueta' => 'Eventos',
    'imagen' => 'reflexion/evento.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_filtro()
	{
		return array (
  0 => 
  array (
    'identificador' => '1',
    'etiqueta' => 'Propiedades basicas',
    'imagen' => 'objetos/ut_formulario.gif',
  ),
  1 => 
  array (
    'identificador' => '2',
    'etiqueta' => 'Elementos de Formulario',
    'imagen' => 'objetos/efs.gif',
  ),
  2 => 
  array (
    'identificador' => '3',
    'etiqueta' => 'Eventos',
    'imagen' => 'reflexion/evento.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_formulario()
	{
		return array (
  0 => 
  array (
    'identificador' => '1',
    'etiqueta' => 'Propiedades basicas',
    'imagen' => 'objetos/ut_formulario.gif',
  ),
  1 => 
  array (
    'identificador' => '2',
    'etiqueta' => 'Elementos (efs)',
    'imagen' => 'objetos/efs.gif',
  ),
  2 => 
  array (
    'identificador' => '3',
    'etiqueta' => 'Eventos',
    'imagen' => 'reflexion/evento.gif',
  ),
);
	}

	static function get_pantallas_objeto_ei_formulario_ml()
	{
		return array (
  0 => 
  array (
    'identificador' => '1',
    'etiqueta' => 'Propiedades basicas',
    'imagen' => 'objetos/ut_formulario_ml.gif',
  ),
  1 => 
  array (
    'identificador' => '2',
    'etiqueta' => 'Elementos (efs)',
    'imagen' => 'objetos/efs.gif',
  ),
  2 => 
  array (
    'identificador' => '3',
    'etiqueta' => 'Eventos',
    'imagen' => 'reflexion/evento.gif',
  ),
);
	}

}
?>