<?php

class toba_mc_item__1000003
{
	static function get_metadatos()
	{
		return array (
  'basica' => 
  array (
    'item_proyecto' => 'toba_editor',
    'item' => '1000003',
    'item_nombre' => 'Analizador de Logs',
    'item_descripcion' => NULL,
    'item_act_buffer_proyecto' => 'toba',
    'item_act_buffer' => 0,
    'item_act_patron_proyecto' => 'toba',
    'item_act_patron' => 'CI',
    'item_act_accion_script' => '',
    'item_solic_tipo' => 'web',
    'item_solic_registrar' => NULL,
    'item_solic_obs_tipo_proyecto' => NULL,
    'item_solic_obs_tipo' => NULL,
    'item_solic_observacion' => NULL,
    'item_solic_cronometrar' => NULL,
    'item_parametro_a' => NULL,
    'item_parametro_b' => NULL,
    'item_parametro_c' => NULL,
    'item_imagen_recurso_origen' => NULL,
    'item_imagen' => NULL,
    'tipo_pagina_clase' => 'toba_tp_basico',
    'tipo_pagina_archivo' => 'nucleo/tipo_pagina/toba_tp_basico.php',
    'item_include_arriba' => NULL,
    'item_include_abajo' => NULL,
    'item_zona_proyecto' => NULL,
    'item_zona' => NULL,
    'item_zona_archivo' => NULL,
    'zona_cons_archivo' => NULL,
    'zona_cons_clase' => NULL,
    'zona_cons_metodo' => NULL,
    'item_publico' => NULL,
    'item_existe_ayuda' => NULL,
    'carpeta' => 0,
    'menu' => NULL,
    'orden' => NULL,
    'publico' => NULL,
    'redirecciona' => NULL,
    'crono' => NULL,
    'solicitud_tipo' => 'web',
    'item_padre' => '/admin/utilidades',
    'cant_dependencias' => '1',
    'cant_items_hijos' => '0',
  ),
  'objetos' => 
  array (
    0 => 
    array (
      'objeto_proyecto' => 'toba_editor',
      'objeto' => 1000001,
      'objeto_nombre' => 'Analizador de Logs',
      'objeto_subclase' => 'ci_analizador',
      'objeto_subclase_archivo' => 'utilitarios/logger/ci_analizador.php',
      'orden' => 0,
      'clase_proyecto' => 'toba',
      'clase' => 'objeto_ci',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
      'fuente_proyecto' => NULL,
      'fuente' => NULL,
      'fuente_motor' => NULL,
      'fuente_host' => NULL,
      'fuente_usuario' => NULL,
      'fuente_clave' => NULL,
      'fuente_base' => NULL,
    ),
  ),
);
	}

}

class toba_mc_comp__1000001
{
	static function get_metadatos()
	{
		return array (
  '_info' => 
  array (
    'proyecto' => 'toba_editor',
    'objeto' => 1000001,
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_ci',
    'subclase' => 'ci_analizador',
    'subclase_archivo' => 'utilitarios/logger/ci_analizador.php',
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'Analizador de Logs',
    'titulo' => NULL,
    'colapsable' => 0,
    'descripcion' => NULL,
    'fuente_proyecto' => NULL,
    'fuente' => NULL,
    'solicitud_registrar' => NULL,
    'solicitud_obj_obs_tipo' => NULL,
    'solicitud_obj_observacion' => NULL,
    'parametro_a' => NULL,
    'parametro_b' => NULL,
    'parametro_c' => NULL,
    'parametro_d' => NULL,
    'parametro_e' => NULL,
    'parametro_f' => NULL,
    'usuario' => NULL,
    'creacion' => '2006-03-21 15:33:14',
    'clase_editor_proyecto' => 'toba_editor',
    'clase_editor_item' => '/admin/objetos_toba/editores/ci',
    'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/ci',
    'clase_icono' => 'objetos/multi_etapa.gif',
    'clase_descripcion_corta' => 'ci',
    'clase_instanciador_proyecto' => 'toba_editor',
    'clase_instanciador_item' => '1642',
    'objeto_existe_ayuda' => NULL,
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
    'cant_dependencias' => '2',
  ),
  '_info_eventos' => 
  array (
    0 => 
    array (
      'identificador' => 'borrar',
      'etiqueta' => 'Borrar',
      'maneja_datos' => 0,
      'sobre_fila' => NULL,
      'confirmacion' => 'Los archivos de log del proyecto actual ser�n eliminados.',
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'borrar.gif',
      'en_botonera' => 1,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => 0,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => 0,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
    1 => 
    array (
      'identificador' => 'refrescar',
      'etiqueta' => '&Refrescar',
      'maneja_datos' => 0,
      'sobre_fila' => NULL,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'refrescar.png',
      'en_botonera' => 1,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => 0,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => 0,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
    2 => 
    array (
      'identificador' => 'siguiente',
      'etiqueta' => '&Siguiente >',
      'maneja_datos' => 0,
      'sobre_fila' => NULL,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => 0,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => 0,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
    3 => 
    array (
      'identificador' => 'anterior',
      'etiqueta' => '< &Anterior',
      'maneja_datos' => 0,
      'sobre_fila' => NULL,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => 0,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => 0,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
  ),
  '_info_puntos_control' => 
  array (
  ),
  '_info_ci' => 
  array (
    'ev_procesar_etiq' => NULL,
    'ev_cancelar_etiq' => NULL,
    'objetos' => NULL,
    'ancho' => '100%',
    'alto' => '100%',
    'posicion_botonera' => 'arriba',
    'tipo_navegacion' => 'tab_h',
    'con_toc' => 0,
  ),
  '_info_ci_me_pantalla' => 
  array (
    0 => 
    array (
      'pantalla' => 1000002,
      'identificador' => 'visor',
      'etiqueta' => 'Visor',
      'descripcion' => NULL,
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => '',
      'eventos' => 'borrar,refrescar,siguiente,anterior',
      'orden' => 1,
      'subclase' => 'pantalla_visor',
      'subclase_archivo' => 'utilitarios/logger/pantalla_visor.php',
    ),
    1 => 
    array (
      'pantalla' => 1000001,
      'identificador' => 'pant_opciones',
      'etiqueta' => 'Opciones',
      'descripcion' => NULL,
      'tip' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'objetos' => 'filtro,pedidos',
      'eventos' => 'borrar,refrescar',
      'orden' => 2,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
    ),
  ),
  '_info_dependencias' => 
  array (
    0 => 
    array (
      'identificador' => 'filtro',
      'proyecto' => 'toba_editor',
      'objeto' => 1000002,
      'clase' => 'objeto_ei_filtro',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ei_filtro.php',
      'subclase' => 'filtro_opciones',
      'subclase_archivo' => 'utilitarios/logger/filtro_opciones.php',
      'fuente' => 'instancia',
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
    1 => 
    array (
      'identificador' => 'pedidos',
      'proyecto' => 'toba_editor',
      'objeto' => 1000003,
      'clase' => 'objeto_ei_cuadro',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ei_cuadro.php',
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'fuente' => NULL,
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
  ),
);
	}

}

class toba_mc_comp__1000002
{
	static function get_metadatos()
	{
		return array (
  '_info' => 
  array (
    'proyecto' => 'toba_editor',
    'objeto' => 1000002,
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_ei_filtro',
    'subclase' => 'filtro_opciones',
    'subclase_archivo' => 'utilitarios/logger/filtro_opciones.php',
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'Opciones Analizador de Logs',
    'titulo' => 'Opciones',
    'colapsable' => 1,
    'descripcion' => NULL,
    'fuente_proyecto' => 'toba_editor',
    'fuente' => 'instancia',
    'solicitud_registrar' => NULL,
    'solicitud_obj_obs_tipo' => NULL,
    'solicitud_obj_observacion' => NULL,
    'parametro_a' => NULL,
    'parametro_b' => NULL,
    'parametro_c' => NULL,
    'parametro_d' => NULL,
    'parametro_e' => NULL,
    'parametro_f' => NULL,
    'usuario' => NULL,
    'creacion' => '2006-03-21 16:29:08',
    'clase_editor_proyecto' => 'toba_editor',
    'clase_editor_item' => '/admin/objetos_toba/editores/ei_filtro',
    'clase_archivo' => 'nucleo/componentes/interface/toba_ei_filtro.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/ei_filtro',
    'clase_icono' => 'objetos/ut_formulario.gif',
    'clase_descripcion_corta' => 'ei_filtro',
    'clase_instanciador_proyecto' => 'toba_editor',
    'clase_instanciador_item' => '1842',
    'objeto_existe_ayuda' => NULL,
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
    'cant_dependencias' => '0',
  ),
  '_info_eventos' => 
  array (
    0 => 
    array (
      'identificador' => 'filtrar',
      'etiqueta' => '&Filtrar',
      'maneja_datos' => 1,
      'sobre_fila' => NULL,
      'confirmacion' => NULL,
      'estilo' => 'ei-boton-filtrar',
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'filtrar.png',
      'en_botonera' => 1,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => 0,
      'defecto' => NULL,
      'grupo' => 'cargado,no_cargado',
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
  ),
  '_info_puntos_control' => 
  array (
  ),
  '_info_formulario' => 
  array (
    'auto_reset' => NULL,
    'ancho' => NULL,
    'ancho_etiqueta' => '150px',
  ),
  '_info_formulario_ef' => 
  array (
    0 => 
    array (
      'objeto_ei_formulario_proyecto' => 'toba_editor',
      'objeto_ei_formulario' => 1000002,
      'objeto_ei_formulario_fila' => 1000001,
      'identificador' => 'proyecto',
      'elemento_formulario' => 'ef_combo',
      'columnas' => 'proyecto',
      'obligatorio' => 1,
      'oculto_relaja_obligatorio' => NULL,
      'orden' => '1',
      'etiqueta' => 'Proyecto',
      'etiqueta_estilo' => NULL,
      'descripcion' => NULL,
      'colapsado' => NULL,
      'desactivado' => NULL,
      'estilo' => NULL,
      'total' => 0,
      'inicializacion' => NULL,
      'estado_defecto' => NULL,
      'solo_lectura' => NULL,
      'carga_metodo' => NULL,
      'carga_clase' => NULL,
      'carga_include' => NULL,
      'carga_col_clave' => NULL,
      'carga_col_desc' => NULL,
      'carga_sql' => 'SELECT proyecto, descripcion_corta FROM apex_proyecto',
      'carga_fuente' => NULL,
      'carga_lista' => NULL,
      'carga_maestros' => NULL,
      'carga_cascada_relaj' => NULL,
      'carga_no_seteado' => '--- Seleccione ---',
      'edit_tamano' => NULL,
      'edit_maximo' => NULL,
      'edit_mascara' => NULL,
      'edit_unidad' => NULL,
      'edit_rango' => NULL,
      'edit_filas' => NULL,
      'edit_columnas' => NULL,
      'edit_wrap' => NULL,
      'edit_resaltar' => NULL,
      'edit_ajustable' => NULL,
      'edit_confirmar_clave' => NULL,
      'popup_item' => NULL,
      'popup_proyecto' => NULL,
      'popup_editable' => NULL,
      'popup_ventana' => NULL,
      'fieldset_fin' => NULL,
      'check_valor_si' => NULL,
      'check_valor_no' => NULL,
      'check_desc_si' => NULL,
      'check_desc_no' => NULL,
      'fijo_sin_estado' => NULL,
      'editor_ancho' => NULL,
      'editor_alto' => NULL,
      'editor_botonera' => NULL,
      'selec_cant_minima' => NULL,
      'selec_cant_maxima' => NULL,
      'selec_utilidades' => NULL,
      'selec_tamano' => NULL,
      'selec_ancho' => NULL,
      'selec_serializar' => NULL,
      'selec_cant_columnas' => NULL,
      'upload_extensiones' => NULL,
    ),
  ),
);
	}

}

class toba_mc_comp__1000003
{
	static function get_metadatos()
	{
		return array (
  '_info' => 
  array (
    'proyecto' => 'toba_editor',
    'objeto' => 1000003,
    'anterior' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'objeto_ei_cuadro',
    'subclase' => NULL,
    'subclase_archivo' => NULL,
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'Analizador de Logs - Solicitudes',
    'titulo' => 'Solicitudes registradas',
    'colapsable' => NULL,
    'descripcion' => NULL,
    'fuente_proyecto' => NULL,
    'fuente' => NULL,
    'solicitud_registrar' => NULL,
    'solicitud_obj_obs_tipo' => NULL,
    'solicitud_obj_observacion' => NULL,
    'parametro_a' => NULL,
    'parametro_b' => NULL,
    'parametro_c' => NULL,
    'parametro_d' => NULL,
    'parametro_e' => NULL,
    'parametro_f' => NULL,
    'usuario' => NULL,
    'creacion' => '2006-03-23 13:54:39',
    'clase_editor_proyecto' => 'toba_editor',
    'clase_editor_item' => '/admin/objetos_toba/editores/ei_cuadro',
    'clase_archivo' => 'nucleo/componentes/interface/toba_ei_cuadro.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '/admin/objetos_toba/editores/ei_cuadro',
    'clase_icono' => 'objetos/cuadro_array.gif',
    'clase_descripcion_corta' => 'ei_cuadro',
    'clase_instanciador_proyecto' => 'toba_editor',
    'clase_instanciador_item' => '1843',
    'objeto_existe_ayuda' => NULL,
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
    'cant_dependencias' => '0',
  ),
  '_info_eventos' => 
  array (
    0 => 
    array (
      'identificador' => 'seleccion',
      'etiqueta' => NULL,
      'maneja_datos' => NULL,
      'sobre_fila' => 1,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'doc.gif',
      'en_botonera' => 0,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => NULL,
      'defecto' => NULL,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
    1 => 
    array (
      'identificador' => 'ultima',
      'etiqueta' => 'Seleccionar Ultima',
      'maneja_datos' => NULL,
      'sobre_fila' => 0,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => NULL,
      'imagen' => NULL,
      'en_botonera' => 1,
      'ayuda' => 'Fija el visor de log a la ultima solicitud producida en el proyecto.',
      'ci_predep' => NULL,
      'implicito' => NULL,
      'defecto' => NULL,
      'grupo' => NULL,
      'accion' => NULL,
      'accion_imphtml_debug' => NULL,
      'accion_vinculo_carpeta' => NULL,
      'accion_vinculo_item' => NULL,
      'accion_vinculo_objeto' => NULL,
      'accion_vinculo_popup' => NULL,
      'accion_vinculo_popup_param' => NULL,
      'accion_vinculo_celda' => NULL,
      'accion_vinculo_target' => NULL,
    ),
  ),
  '_info_puntos_control' => 
  array (
  ),
  '_info_cuadro' => 
  array (
    'titulo' => NULL,
    'subtitulo' => NULL,
    'sql' => NULL,
    'columnas_clave' => 'numero',
    'clave_datos_tabla' => NULL,
    'archivos_callbacks' => NULL,
    'ancho' => NULL,
    'ordenar' => NULL,
    'exportar_xls' => NULL,
    'exportar_pdf' => NULL,
    'paginar' => 1,
    'tamano_pagina' => 8,
    'tipo_paginado' => 'P',
    'scroll' => NULL,
    'alto' => NULL,
    'eof_invisible' => NULL,
    'eof_customizado' => 'No se encontraron solicitudes registradas',
    'pdf_respetar_paginacion' => NULL,
    'pdf_propiedades' => NULL,
    'asociacion_columnas' => NULL,
    'dao_nucleo_proyecto' => NULL,
    'dao_clase' => NULL,
    'dao_metodo' => NULL,
    'dao_parametros' => NULL,
    'dao_archivo' => '',
    'cc_modo' => NULL,
    'cc_modo_anidado_colap' => NULL,
    'cc_modo_anidado_totcol' => NULL,
    'cc_modo_anidado_totcua' => NULL,
  ),
  '_info_cuadro_columna' => 
  array (
    0 => 
    array (
      'orden' => '1',
      'titulo' => NULL,
      'estilo_titulo' => NULL,
      'estilo' => 'col-num-p2',
      'ancho' => NULL,
      'clave' => 'numero',
      'formateo' => NULL,
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
    1 => 
    array (
      'orden' => '2',
      'titulo' => 'Fecha',
      'estilo_titulo' => 'ei-cuadro-col-tit',
      'estilo' => 'col-tex-p1',
      'ancho' => NULL,
      'clave' => 'fecha',
      'formateo' => NULL,
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
    2 => 
    array (
      'orden' => '3',
      'titulo' => 'Operaci�n',
      'estilo_titulo' => NULL,
      'estilo' => 'col-tex-p1',
      'ancho' => NULL,
      'clave' => 'operacion',
      'formateo' => NULL,
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
    3 => 
    array (
      'orden' => '4',
      'titulo' => 'Usuario',
      'estilo_titulo' => NULL,
      'estilo' => 'col-tex-p1',
      'ancho' => NULL,
      'clave' => 'usuario',
      'formateo' => NULL,
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
    4 => 
    array (
      'orden' => '5',
      'titulo' => 'Host',
      'estilo_titulo' => NULL,
      'estilo' => 'col-tex-p1',
      'ancho' => NULL,
      'clave' => 'host',
      'formateo' => NULL,
      'vinculo_indice' => NULL,
      'no_ordenar' => NULL,
      'mostrar_xls' => NULL,
      'mostrar_pdf' => NULL,
      'pdf_propiedades' => NULL,
      'total' => NULL,
      'total_cc' => NULL,
    ),
  ),
  '_info_cuadro_cortes' => 
  array (
  ),
);
	}

}

?>