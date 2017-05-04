<?php

class toba_mc_comp__1386
{
	static function get_metadatos()
	{
		return array (
  '_info' => 
  array (
    'proyecto' => 'toba_editor',
    'objeto' => 1386,
    'anterior' => NULL,
    'identificador' => NULL,
    'reflexivo' => NULL,
    'clase_proyecto' => 'toba',
    'clase' => 'toba_ci',
    'subclase' => 'ci_principal',
    'subclase_archivo' => 'objetos_toba/ei_formulario_ml/ci_principal.php',
    'objeto_categoria_proyecto' => NULL,
    'objeto_categoria' => NULL,
    'nombre' => 'Editor OBJETO - ei_formulario_ml',
    'titulo' => NULL,
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
    'creacion' => NULL,
    'punto_montaje' => 12,
    'clase_editor_proyecto' => 'toba_editor',
    'clase_editor_item' => '1000249',
    'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
    'clase_vinculos' => NULL,
    'clase_editor' => '1000249',
    'clase_icono' => 'objetos/multi_etapa.gif',
    'clase_descripcion_corta' => 'ci',
    'clase_instanciador_proyecto' => 'toba_editor',
    'clase_instanciador_item' => '1642',
    'objeto_existe_ayuda' => NULL,
    'ap_clase' => NULL,
    'ap_archivo' => NULL,
    'ap_punto_montaje' => NULL,
    'cant_dependencias' => 5,
    'posicion_botonera' => 'ambos',
  ),
  '_info_eventos' => 
  array (
    0 => 
    array (
      'evento_id' => 61,
      'identificador' => 'eliminar',
      'etiqueta' => '&Eliminar',
      'maneja_datos' => 0,
      'sobre_fila' => 0,
      'confirmacion' => 'Este comando ELIMINARA el COMPONENTE y sus asociaciones con otros elementos del sistema. �Desea continuar?',
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'borrar.gif',
      'en_botonera' => 1,
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
      'accion_vinculo_servicio' => NULL,
      'es_seleccion_multiple' => 0,
      'es_autovinculo' => 0,
    ),
    1 => 
    array (
      'evento_id' => 62,
      'identificador' => 'procesar',
      'etiqueta' => '&Guardar',
      'maneja_datos' => 1,
      'sobre_fila' => 0,
      'confirmacion' => NULL,
      'estilo' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'guardar.gif',
      'en_botonera' => 1,
      'ayuda' => NULL,
      'ci_predep' => NULL,
      'implicito' => NULL,
      'defecto' => 1,
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
      'accion_vinculo_servicio' => NULL,
      'es_seleccion_multiple' => 0,
      'es_autovinculo' => 0,
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
    'ancho' => '600px',
    'alto' => NULL,
    'posicion_botonera' => 'ambos',
    'tipo_navegacion' => 'tab_h',
    'con_toc' => NULL,
    'botonera_barra_item' => NULL,
  ),
  '_info_ci_me_pantalla' => 
  array (
    0 => 
    array (
      'pantalla' => 368,
      'identificador' => '1',
      'etiqueta' => 'Propiedades basicas',
      'descripcion' => NULL,
      'tip' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'objetos/ut_formulario_ml.gif',
      'objetos' => NULL,
      'eventos' => NULL,
      'orden' => 1,
      'punto_montaje' => 12,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'template' => NULL,
      'template_impresion' => NULL,
    ),
    1 => 
    array (
      'pantalla' => 369,
      'identificador' => '2',
      'etiqueta' => 'Elementos (efs)',
      'descripcion' => 'Definir los campos o [wiki:Referencia/efs efs] que contiene el formulario.',
      'tip' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'objetos/efs.gif',
      'objetos' => NULL,
      'eventos' => NULL,
      'orden' => 2,
      'punto_montaje' => 12,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'template' => NULL,
      'template_impresion' => NULL,
    ),
    2 => 
    array (
      'pantalla' => 370,
      'identificador' => '3',
      'etiqueta' => 'Eventos',
      'descripcion' => NULL,
      'tip' => NULL,
      'imagen_recurso_origen' => 'apex',
      'imagen' => 'evento.png',
      'objetos' => NULL,
      'eventos' => NULL,
      'orden' => 3,
      'punto_montaje' => 12,
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'template' => NULL,
      'template_impresion' => NULL,
    ),
  ),
  '_info_obj_pantalla' => 
  array (
    0 => 
    array (
      'pantalla' => 368,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'dep_id' => 48,
      'orden' => 1,
      'identificador_pantalla' => '1',
      'identificador_dep' => 'base',
    ),
    1 => 
    array (
      'pantalla' => 369,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'dep_id' => 50,
      'orden' => 1,
      'identificador_pantalla' => '2',
      'identificador_dep' => 'efs',
    ),
    2 => 
    array (
      'pantalla' => 370,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'dep_id' => 51,
      'orden' => 1,
      'identificador_pantalla' => '3',
      'identificador_dep' => 'eventos',
    ),
    3 => 
    array (
      'pantalla' => 368,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'dep_id' => 52,
      'orden' => 2,
      'identificador_pantalla' => '1',
      'identificador_dep' => 'prop_basicas',
    ),
  ),
  '_info_evt_pantalla' => 
  array (
    0 => 
    array (
      'pantalla' => 368,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'evento_id' => 61,
      'identificador_pantalla' => '1',
      'identificador_evento' => 'eliminar',
    ),
    1 => 
    array (
      'pantalla' => 368,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'evento_id' => 62,
      'identificador_pantalla' => '1',
      'identificador_evento' => 'procesar',
    ),
    2 => 
    array (
      'pantalla' => 369,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'evento_id' => 61,
      'identificador_pantalla' => '2',
      'identificador_evento' => 'eliminar',
    ),
    3 => 
    array (
      'pantalla' => 369,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'evento_id' => 62,
      'identificador_pantalla' => '2',
      'identificador_evento' => 'procesar',
    ),
    4 => 
    array (
      'pantalla' => 370,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'evento_id' => 61,
      'identificador_pantalla' => '3',
      'identificador_evento' => 'eliminar',
    ),
    5 => 
    array (
      'pantalla' => 370,
      'proyecto' => 'toba_editor',
      'objeto_ci' => 1386,
      'evento_id' => 62,
      'identificador_pantalla' => '3',
      'identificador_evento' => 'procesar',
    ),
  ),
  '_info_dependencias' => 
  array (
    0 => 
    array (
      'identificador' => 'prop_basicas',
      'proyecto' => 'toba_editor',
      'objeto' => 1388,
      'clase' => 'toba_ei_formulario',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ei_formulario.php',
      'subclase' => 'form_prop_basicas',
      'subclase_archivo' => 'objetos_toba/ei_formulario_ml/form_prop_basicas.php',
      'fuente' => 'instancia',
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
    1 => 
    array (
      'identificador' => 'eventos',
      'proyecto' => 'toba_editor',
      'objeto' => 1748,
      'clase' => 'toba_ci',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
      'subclase' => 'ci_eventos',
      'subclase_archivo' => 'objetos_toba/ci_eventos.php',
      'fuente' => NULL,
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
    2 => 
    array (
      'identificador' => 'efs',
      'proyecto' => 'toba_editor',
      'objeto' => 1390,
      'clase' => 'toba_ci',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ci.php',
      'subclase' => 'ci_efs',
      'subclase_archivo' => 'objetos_toba/efs/ci_efs.php',
      'fuente' => NULL,
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
    3 => 
    array (
      'identificador' => 'datos',
      'proyecto' => 'toba_editor',
      'objeto' => 1536,
      'clase' => 'toba_datos_relacion',
      'clase_archivo' => 'nucleo/componentes/persistencia/toba_datos_relacion.php',
      'subclase' => NULL,
      'subclase_archivo' => NULL,
      'fuente' => 'instancia',
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
    4 => 
    array (
      'identificador' => 'base',
      'proyecto' => 'toba_editor',
      'objeto' => 1355,
      'clase' => 'toba_ei_formulario',
      'clase_archivo' => 'nucleo/componentes/interface/toba_ei_formulario.php',
      'subclase' => 'eiform_prop_base',
      'subclase_archivo' => 'objetos_toba/eiform_prop_base.php',
      'fuente' => 'instancia',
      'parametros_a' => NULL,
      'parametros_b' => NULL,
    ),
  ),
);
	}

}

?>