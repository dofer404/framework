INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef', 'ef', 'Ancestro de todos los elementos de formulario', 'dependencias: Dependencias del EF, separadas por comas (,): opcional;
javascript: Javascript asociado al EF, la notacion es evento,codigo: opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_barra_divisora', 'ef', 'La Barra divisiora es un componente sin estado, solo sirve para separar visualmente bloques de EFs', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_checkbox', 'ef', 'Campo Checkbox (Ausencia o presencia de una propiedad)', 'valor: Valor de la propiedad cuando esta seteada (DB): obligatorio;
valor_info: Valor de la propiedad seteada legible para el usuario: obligatorio;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo', 'ef', 'Ancestro del todos los combos', 'No posee: Nada: obligatorio;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo_dao', 'ef_combo', 'Este combo se inicializa en base a un DAO', 'dao: Nombre del DAO a utilizar: opcional;
claves: Cantidad de claves (por defecto 1): opcional;
no_seteado: Etiqueta que representa el valor NULL: opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo_db', 'ef_combo', 'Combo de opciones generado a partir de un SELECT', 'sql: QUERY que carga el combo. Tiene que devolver 2 columnas (id a grabar en la base y valor legible al usuario): obligatorio;
no_seteado: Nombre que representa la ausencia de dato (en la base se graba como NULL): opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo_db_proyecto', 'ef_combo_db', 'Combo que filtra los elementos segun el proyecto ACTUAL. (Puede incorporar opcionalmente a los del proyecto TOBA)', 'sql: QUERY que carga el combo. Tiene que devolver 3 columnas (proyecto, id del dato y valor legible al usuario). Es necesario que se posicione el string \'%w%\' en el lugar donde se tiene que concatenar el WHERE automatico: obligatorio;
columna_proyecto: columna de la tabla que representa el proyecto: obligatorio;
incluir_toba: Hay que incluir el proyecto Toba en la lista?: opcional;
no_seteado: Nombre que representa la ausencia de dato (en la base se graba como NULL): opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo_editable', 'ef', 'Combo + Editable', 'sql: SELECT que arma el combo: obligatorio;
no_seteado: Descripcion que represente el valor inactivo del combo: opcional;
estado: Estado inicial del editable: opcional;
tamano: Tamano de la interface del editable: obligatorio;
maximo: Tamano maximo soportado del editable: opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo_lista', 'ef_combo', 'Combo basado en una lista explicita', 'lista: La lista representada como un STRING con los elementos separados por COMAS: obligatorio;
no_seteado: Valor que representa el estado de NO activado: opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_combo_lista_c', 'ef_combo', 'Combo basado en una lista explicita', 'lista: Los pares se separan por \"/\" y la clave/valor se separa por \",\": obligatorio;
no_seteado: Valor que representa el estado de NO activado: opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_cuit', 'ef', 'CUIT/CUIL', NULL, 'toba', '0', '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable', 'ef', 'Campo de texto editable', 'tamano: Cantidad de caracteres que posee la interface: obligatorio;
maximo: Maxima cantidad de caracteres soportada (Si no se especifica es igual al tama�o): opcional;
estado: Cargar el elemento con un estado: opcional;
sql: SQL que devuelve el valor a cargar: opcional;
solo_lectura: Hacer el campo solo lectura (setarlo a 1): opcional;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_clave', 'ef_editable', 'Campo para ingresar contrase�as', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_fecha', 'ef_editable', 'Campo para ingresar fechas', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_moneda', 'ef_editable_numero', 'Representa un importe monetario', 'mascara: Formateo del valor (por defecto $ ###.###,00): opcional;
rango: Intervalo de n�meros permitidos. Los corchetes incluyen el l�mite, los par�ntesis no, por defecto [0..*]: opcional;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_multilinea', 'ef_editable', 'Campo editable de N lineas', 'columnas: Cantidad de columnas:opcional;
filas: Cantidad de filas:opcional;
resaltar: Incorporar boton de seleccion de texto (setear a 1):opcional;
wrap: soft | hard | off:opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_numero', 'ef_editable', 'Campo de texto editable que solo acepta numeros', 'cifras: Cantidad de cifras del numero:opcional;
mascara: Formateo del valor (por defecto ###.###,##): opcional;
rango: Intervalo de n�meros permitidos los corchetes incluyen el l�mite, los par�ntesis no, formato: [-5..*], mensaje de error: opcional;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_numero_porcentaje', 'ef_editable_numero', 'Elemento de formulario que permite cargar porcentajes', 'rango: Intervalo de n�meros permitidos. Los corchetes incluyen el l�mite, los par�ntesis no, por defecto [0..100]: opcional;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_editable_textarea', 'ef_editable', 'Campo editable de varias l�neas de alto.', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_elemento_ini', 'ef', 'Permite elegir un TIPO de elemento de una lista e inicializarlo (con una sintaxis similar a la de CSS)', 'sql: El query tiene que devolver 4 campos o mas (claves, Desc. combo, Descripcion y Parametros):obligatorio;
claves: Indica la cantidad de claves que hay en el SQL:obligatorio;
filas: Cantidad de filas en el TEXTAREA de inicializacion:opcional;
columnas: Cantidad de columnas en el TEXTAREA de inicializacion:opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_elemento_ini_proyecto', 'ef_elemento_ini', 'Permite elegir un TIPO de elemento de una lista e inicializarlo (con una sintaxis similar a la de CSS)', 'sql: El query tiene que devolver 4 campos o mas (claves, Desc. combo, Descripcion y Parametros). El SQL tienen que tener una marca %w% para concatenarle el WHERE:obligatorio;
claves: Indica la cantidad de claves que hay en el SQL:obligatorio;
filas: Cantidad de filas en el TEXTAREA de inicializacion:opcional;
columnas: Cantidad de columnas en el TEXTAREA de inicializacion:opcional;', 'toba', '1', '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_fieldset', 'ef', 'Fieldset', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_fijo', 'ef', 'Elemento que no cambia de valor', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_html', 'ef', 'Crear HTML con una interface WYSIWYG', 'ancho: Ancho del Editor (pixels o porcentaje): opcional;
alto: Ancho del Editor (pixels o porcentaje): opcional;
botones: Modelo de botones a utilizar (Toba, Basic, Defualt): opcional;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_multi_seleccion', 'ef', 'Clase ABSTRACT. Permite seleccionar N elementos de una lista, no tiene salida gr�fica. EN BETA.', 'valores: Lista de valores fijos: opcional;
tamanio: Cantidad de elementos a mostrar inicialmente: opcional;
cant_maxima: Cantidad m�xima de elementos que puede seleccionar el cliente: opcional;
cant_minima: Cantidad m�nima de elementos que debe seleccionar el cliente: opcional;', 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_multi_seleccion_check', 'ef_multi_seleccion', 'Permite seleccionar N elementos usando un conjunto de checkboxes.', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_multi_seleccion_doble', 'ef_multi_seleccion', 'Permite seleccionar N elementos moviendo los elementos de una lista a otra.', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_multi_seleccion_lista', 'ef_multi_seleccion', 'Permite seleccionar N elementos en forma de una lista HTML. EN BETA.', 'mostrar_utilidades: Muestra una peque�a barra de herramientas para facilitar el uso: opcional;
(Ver los de ef_multi_seleccion tambi�n)', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_oculto', 'ef', 'Elemento no visible', 'estado: Estado en el que se va a setear el elemento oculto:opcional;', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_oculto_proyecto', 'ef_oculto', 'Elemento invisible que maneja la clave de proyecto del registro. Solo permite editar registros del proyecto ACTIVO', NULL, 'toba', '1', '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_oculto_secuencia', 'ef_oculto', 'Elemento oculto que maneja una secuencia', NULL, 'toba', NULL, '1');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_oculto_usuario', 'ef_oculto', 'Se completa con el usuario que realizo la solicitud', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_popup', 'ef', 'Muestra un pop-up con un item asociado.', 'tamano: Tama�o del ef;
sql: SQL que carga los valores del ef;
columna_clave: Columna clave de la tabla;
item_destino: Item que se invoca;
ventana: ancho, alto, scroll (yes | no);', 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_radio', 'ef', 'Permite seleccionar un elemento de un conjunto utilizando Radio Buttons.', NULL, 'toba', NULL, '0');
INSERT INTO apex_elemento_formulario (elemento_formulario, padre, descripcion, parametros, proyecto, exclusivo_toba, obsoleto) VALUES ('ef_upload', 'ef', 'Permite subir un archivo desde el cliente a un directorio temporal en el servidor.', NULL, 'toba', NULL, '0');
