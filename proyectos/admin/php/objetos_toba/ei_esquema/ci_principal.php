<?php
require_once('objetos_toba/ci_editores_toba.php');
require_once('modelo/componentes/info_ei.php');

class ci_principal extends ci_editores_toba
{
	protected $clase_actual = 'objeto_ei_esquema';	
	
	function get_dbr_eventos()
	{
		return $this->get_entidad()->tabla('eventos');
	}
	
	function get_modelos_evento()
	{
		return info_ei::get_modelos_evento();
	}

	function get_eventos_estandar($modelo)
	{
		return info_ei::get_lista_eventos_estandar($modelo);
	}
	
	//*******************************************************************
	//*****************  PROPIEDADES BASICAS  ***************************
	//*******************************************************************

	function evt__prop_basicas__modificacion($datos)
	{
		$this->get_entidad()->tabla('prop_basicas')->set($datos);		
	}
	
	function evt__prop_basicas__carga()
	{
		return $this->get_entidad()->tabla('prop_basicas')->get();
	}

}