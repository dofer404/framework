<?php 
class form_varios extends toba_ei_formulario
{

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
			
			{$this->objeto_js}.evt__popup_editable__procesar = function(es_inicial)
			{
				var cheq = !this.ef('popup_editable').chequeado();
				this.ef('popup_carga_desc_metodo').mostrar(cheq, true);
				this.ef('popup_carga_desc_estatico').mostrar(cheq, true);
				this.ef('popup_carga_desc_include').mostrar(cheq, true);
				this.ef('popup_carga_desc_clase').mostrar(cheq, true);	
				this.evt__popup_carga_desc_estatico__procesar(es_inicial);
			}

			{$this->objeto_js}.evt__popup_carga_desc_estatico__procesar = function(es_inicial)
			{
				var cheq = this.ef('popup_carga_desc_estatico').chequeado();
				this.ef('popup_carga_desc_include').mostrar(cheq, true);
				this.ef('popup_carga_desc_clase').mostrar(cheq, true);				
			}
		";
	}
}

?>