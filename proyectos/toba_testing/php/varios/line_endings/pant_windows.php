<?php
class pant_windows extends toba_ei_pantalla
{
		function generar_layout()
	{
		$nombre = toba::proyecto()->get_path_php(). '/varios/line_endings/archivo_linux.php';
		$archivo = new toba_archivo_php($nombre);
		echo '<pre><span>Esto vendria a ser el codigo pelado</span><br>';
		echo toba_archivo_php::codigo_sacar_tags_php(file_get_contents($nombre));
		echo '</pre>';
		echo '<hr> Y este el codigo Bonito <br><pre>';
		echo $archivo->get_codigo_php_puro();
		echo '</pre><hr>';
	}
}

?>