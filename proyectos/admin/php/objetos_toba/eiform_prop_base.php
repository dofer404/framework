<?php
require_once('nucleo/browser/clases/objeto_ei_formulario.php'); 
//--------------------------------------------------------------------
class eiform_prop_base extends objeto_ei_formulario
{
	
	function extender_objeto_js()
	{
		$clase = $this->controlador->get_clase_actual();
		if (! in_array($clase, dao_editores::get_clases_con_fuente_datos())) {
			//Oculta la fuente
			echo "
				{$this->objeto_js}.configurar = function() {
					this.ef('fuente_datos').ocultar();
				}
			";
		}
		echo "						
			{$this->objeto_js}.evt__subclase_archivo__procesar = function(inicial) {
				if (!inicial && this.ef('subclase').valor() == '') {
					var archivo = this.ef('subclase_archivo').valor();
					var basename = archivo.replace( /.*\//, '' );
					var clase = basename.substring(0, basename.lastIndexOf('.'));
					this.ef('subclase').cambiar_valor(clase);
				}
			}
			";
	}
	

}

?>