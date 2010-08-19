<?php
/**
 * Description of toba_extractor_clases
 *
 * @author sp14ab
 */
include_once 'toba_manejador_archivos.php';
class toba_extractor_clases
{
	const regexp_eliminar_comentarios = '%(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|(//.*)%i';
	const regexp_extractor = '/.*\b(class|interface)[\t\r\n ]+(\w+)[\t\r\n \{]+(?:[\t\r\n ]*extends[\t\r\n ]*(\w*))?/i';

	/**
	 * @var array Los puntos de montaje de donde se tienen que cargar las clases
	 * Estructura:
	 * array(
	 *		path => array(
	 *			'archivo_salida' => path del archivo salida. Relativo al punto de montaje, no empieza con barra
	 *			'dirs_excluidos' => array() <-- opcional. Los directorios a excluir relativos al punto de montaje
	 *			'extras' => array() <-- opcional. Pares 'nombre_clase' => 'path_relativo_al_punto_de_montaje' se agregan como vienen. Util para agregar un archivo de una carpeta exclu�da
	 *		)
	 * )
	 */
	protected $puntos_montaje;
	protected $extends_excluidos;

	protected $registro;
	protected $clases_repetidas;

	/**
	 * @var consola
	 */
	protected $consola;

	function  __construct($consola, $puntos_montaje)
	{
		$this->consola = $consola;
		$this->puntos_montaje = $puntos_montaje;
		$this->extends_excluidos = array();
	}

	/**
	 * @ignore
	 */
	function comparar()
	{
		$toba = toba_nucleo::get_indice_archivos();
		$toba_keys = array_keys($toba);
		$aca_keys = array_keys(toba_autoload::$clases);
		$toba_no_aca = 0;
		foreach($toba_keys as $clase) {
			if (!in_array($clase, $aca_keys)) {
				echo "$clase:" .$toba[$clase]."\n";
				$toba_no_aca++;
			}
		}
	}

	/**
	 * Setea los nombres de las clases de las cuales si extienden no van en el autoload
	 * @param array $extends arreglo unidimensional de nombres de clases
	 */
	function set_extends_excluidos($extends)
	{
		$this->extends_excluidos = $extends;
	}

    function generar()
	{
		foreach ($this->puntos_montaje as $path => $data) {
			if (!is_dir($path)) {
				$this->consola->mensaje("\n[WARNING] El punto de montaje $path no se encuentra, por lo tanto los archivos de este punto de montaje no ser�n cargados");
				continue;	// simplemente se ignora
			}

			$this->init_registro();
			
			$dirs_excluidos = (isset($data['dirs_excluidos'])) ? $data['dirs_excluidos'] : array();
			$archivos  = $this->obtener_archivos($path, $dirs_excluidos);

			$extras = (isset($data['extras'])) ? $data['extras'] : array();
			$arreglo = $this->generar_arreglo($path, $archivos, $extras);
			
			$this->generar_archivo($path.'/'.$data['archivo_salida'], $arreglo, $path);
		}
	}

	protected function obtener_archivos($path, $excluidos = array())
	{
		$excluidos = $this->preparar_excluidos($path, $excluidos);
		$archivos  = toba_manejador_archivos::get_archivos_directorio($path, '/.*\.php$/', true, $excluidos);
		sort($archivos, SORT_STRING);

		return $archivos;
	}

	protected function preparar_excluidos($path, $excluidos)
	{
		foreach ($excluidos as $key => $excluido) {
			if (!comienza_con($excluido, '/')) {
				$excluidos[$key] = "$path/$excluido";
			} else {
				$excluidos[$key] = "$path$excluido";
			}
		}

		return $excluidos;
	}

	protected function generar_arreglo($path_montaje, &$archivos, $extras = array())
	{
		$clases = '';

		foreach ($archivos as $archivo) {
			$contenido = file_get_contents($archivo);
			
			$contenido = preg_replace(self::regexp_eliminar_comentarios, '', $contenido);	// removemos comentarios

			// matches[1]: cada elemento ac� trae 'class', 'interface' o nada
			// matches[2]: cada elemento ac� trae el nombre de la clase o interfaz
			// matches[3]: cada elemento ac� trae de que clase extiende
			preg_match_all(self::regexp_extractor, $contenido, $matches);
			
			if (empty($matches[1])) continue;	// No es una clase o una interfaz. No hay que incluirla

			foreach ($matches[1] as $key => $tipo) {
				if ($tipo == 'class') {
					if (in_array($matches[3][$key], $this->extends_excluidos)) {
						continue;
					}
				}
				$clase = $matches[2][$key];
				$this->registrar_clase($path_montaje, $clase, $archivo);
				$path = substr(str_replace($path_montaje, '', $archivo), 1); // Sacamos el $path_montaje para que quede relativo al mismo

				$clases .= sprintf("\t\t'%s' => '%s',\n", $clase, $path);
			}
		}

		foreach ($extras as $clase => $path) {
			$clases .= sprintf("\t\t'%s' => '%s',\n", $clase, $path);
		}

		return $clases;
	}

	protected function init_registro()
	{
		unset($this->registro);
		unset($this->clases_repetidas);
		$this->registro = array();
		$this->clases_repetidas = array();
	}

	protected function registrar_clase($montaje, $clase, $path)
	{
		if (isset($this->registro[$montaje][$clase])) {	// La clase con nombre $clase ya existe
			if (!isset($this->clases_repetidas[$montaje][$clase])) {	// La clase $nombre no se hab�a registrado como repetida
				$this->clases_repetidas[$montaje][$clase][] = $this->registro[$montaje][$clase];
			}
			$this->clases_repetidas[$montaje][$clase][] = $path;
		} else {
			$this->registro[$montaje][$clase] = $path;
		}
	}

	protected function generar_archivo($path, $contenido, $punto_montaje)
	{
		$nombre_clase = basename($path, '.php');
		$comentario = "/**\n * Esta clase fue y ser� generada autom�ticamente. NO EDITAR A MANO.\n * @ignore\n */";
		$arreglo = sprintf("\tstatic \$clases = array(\n%s\t);", $contenido);
		$metodo_consultor = "\tstatic function existe_clase(\$nombre)\n\t{\n\t\treturn isset(self::\$clases[\$nombre]);\n\t}\n";
		$metodo_cargador = "\tstatic function cargar(\$nombre)\n\t{\n\t\tif (self::existe_clase(\$nombre)) { require_once(dirname(__FILE__) .'/'. self::\$clases[\$nombre]); }\n\t}\n";
		$clase = sprintf("<?php\n%s\nclass %s \n{\n%s\n%s\n%s\n}\n?>", $comentario, $nombre_clase, $metodo_consultor, $metodo_cargador, $arreglo);

//		if (file_exists($path)) {	// Hacemos un backup por las dudas que se rompa
//			file_put_contents($path.'.bak', file_get_contents($path));
//		}
		file_put_contents($path, $clase);
		$this->mostrar_clases_repetidas();
	}

	protected function mostrar_clases_repetidas()
	{
		foreach ($this->clases_repetidas as $montaje => $clase) {
			$this->consola->mensaje("\n[$montaje] Existen clases repetidas, la �nica que se cargar� en el autoload ser� la �ltima de cada lista", true);
			foreach ($clase as $key => $paths) {
				$this->consola->mensaje("\n[$key]");
				foreach ($paths as $path) {
					$this->consola->mensaje($path, true);
				}
			}
		}
	}
}
?>