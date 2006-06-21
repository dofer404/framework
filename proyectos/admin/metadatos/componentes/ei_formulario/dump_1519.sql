------------------------------------------------------------
--[1519]--  ITEM - Propiedades B�sicas 
------------------------------------------------------------
INSERT INTO apex_objeto (proyecto, objeto, anterior, reflexivo, clase_proyecto, clase, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion) VALUES ('admin', '1519', NULL, '0', 'toba', 'objeto_ei_formulario', 'form_prop_basicas', 'editores/editor_item/form_prop_basicas.php', 'toba', NULL, 'ITEM - Propiedades B�sicas', NULL, NULL, 'Propiedades del ITEM', 'admin', 'instancia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_eventos (proyecto, evento_id, objeto, identificador, etiqueta, maneja_datos, sobre_fila, confirmacion, estilo, imagen_recurso_origen, imagen, en_botonera, ayuda, orden, ci_predep, implicito, display_datos_cargados, grupo, accion, accion_imphtml_debug, accion_vinculo_carpeta, accion_vinculo_item, accion_vinculo_objeto, accion_vinculo_popup, accion_vinculo_popup_param, accion_vinculo_target, accion_vinculo_celda) VALUES ('admin', '93', '1519', 'modificacion', 'Modificacion', '1', NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ut_formulario (objeto_ut_formulario_proyecto, objeto_ut_formulario, tabla, titulo, ev_agregar, ev_agregar_etiq, ev_mod_modificar, ev_mod_modificar_etiq, ev_mod_eliminar, ev_mod_eliminar_etiq, ev_mod_limpiar, ev_mod_limpiar_etiq, ev_mod_clave, clase_proyecto, clase, auto_reset, ancho, ancho_etiqueta, campo_bl, scroll, filas, filas_agregar, filas_agregar_online, filas_undo, filas_ordenar, columna_orden, filas_numerar, ev_seleccion, alto, analisis_cambios) VALUES ('admin', '1519', 'apex_item', 'Propiedades', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '150px', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1499', 'accion', 'ef_editable', 'actividad_accion', NULL, 'tamano_:_ 60_;_
maximo_:_ 80_;_
', '11', 'Archivo PHP', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1500', 'buffer', 'ef_combo', 'actividad_buffer_proyecto, actividad_buffer', NULL, 'dao_:_ get_buffers_;_
clase_:_ dao_editores_;_
include_:_ db/dao_editores.php_;_
clave_:_ proyecto,buffer_;_
valor_:_ descripcion_corta_;_
predeterminado_:_ toba,0_;_
', '9', 'Script PHP', NULL, 'El comportamiento se encuentra almacenado en la base y no en el sistema de archivos.', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1501', 'carpeta', 'ef_oculto', 'carpeta', NULL, 'estado_:_ 0_;_
', '27', 'carpeta', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1502', 'descripcion', 'ef_editable_multilinea', 'descripcion', NULL, 'filas_:_ 4_;_
columnas_:_ 55_;_
', '7', 'Descripcion', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1503', 'imagen', 'ef_editable', 'imagen', NULL, 'tamano_:_ 60_;_
', '18', 'Imagen', NULL, 'Imagen que representa al item', '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1504', 'imagen_recurso_orige', 'ef_combo', 'imagen_recurso_origen', NULL, 'no_seteado_:_ Ninguno_;_
sql_:_ SELECT recurso_origen, descripcion FROM apex_recurso_origen ORDER BY descripcion_;_
', '17', 'Imagen - origen', NULL, 'Procedencia de la imagen', '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1505', 'item', 'ef_fijo', 'item', NULL, 'tamano_:_ 60_;_
', '1', 'Identificador', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1506', 'menu', 'ef_checkbox', 'menu', NULL, 'valor_:_ 1_;_
', '15', 'Mostrar en el men�', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1507', 'nivel_acceso', 'ef_oculto', 'nivel_acceso', NULL, 'estado_:_ 0_;_
', '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1508', 'nombre', 'ef_editable', 'nombre', '1', 'tamano_:_ 60_;_
', '3', 'Nombre', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1509', 'orden', 'ef_editable_numero', 'orden', NULL, 'tamano_:_ 2_;_
', '16', 'Orden en el men�', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1510', 'padre', 'ef_combo', 'padre_proyecto, padre', NULL, 'dao_:_ get_carpetas_posibles_;_
clase_:_ dao_editores_;_
include_:_ db/dao_editores.php_;_
clave_:_ proyecto,id_;_
valor_:_ nombre_;_
', '2', 'Carpeta Padre', NULL, NULL, NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1511', 'pagina_tipo', 'ef_combo', 'pagina_tipo_proyecto, pagina_tipo', NULL, 'dao_:_ get_tipos_pagina_;_
clase_:_ dao_editores_;_
include_:_ db/dao_editores.php_;_
clave_:_ proyecto,pagina_tipo_;_
valor_:_ descripcion_;_
predeterminado_:_ toba,normal_;_
', '6', 'Modelo Pagina', NULL, 'Modelo para manejar templates de HTML (include de PHP que se aplica antes y despues de la ACTIVIDAD)', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1512', 'parametro_a', 'ef_editable', 'parametro_a', NULL, 'tamano_:_ 40_;_
maximo_:_ 100_;_
', '12', 'Parametro A', NULL, NULL, '1', NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1513', 'parametro_b', 'ef_editable', 'parametro_b', NULL, 'tamano_:_ 40_;_
maximo_:_ 100_;_
', '13', 'Parametro B', NULL, NULL, '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1514', 'parametro_c', 'ef_editable', 'parametro_c', NULL, 'tamano_:_ 40_;_
maximo_:_ 100_;_
', '14', 'Parametro C', NULL, NULL, '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1515', 'patron', 'ef_combo', 'actividad_patron_proyecto, actividad_patron', NULL, 'dao_:_ get_comportamientos_;_
clase_:_ dao_editores_;_
include_:_ db/dao_editores.php_;_
clave_:_ proyecto,patron_;_
valor_:_ descripcion_corta_;_
predeterminado_:_ toba,CI_;_
', '10', 'Comportamiento', NULL, 'Tambi�n llamado Patrones, estos comportamientos son los predefinidos en el sistema, tomando desiciones de qu� hacer con los objetos involucrados.', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1517', 'publico', 'ef_checkbox', 'publico', NULL, 'valor_:_ 1_;_
', '26', 'Publico', NULL, 'El ITEM puede ser accedido por cualquier USUARIO, sin considerar el GRUPO de ACCESO al que pertenece.', '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1518', 'solicitud_obs_tipo', 'ef_combo', 'solicitud_obs_tipo_proyecto, solicitud_obs_tipo', NULL, 'dao_:_ get_tipo_observaciones_solicitud_;_
clase_:_ dao_editores_;_
include_:_ db/dao_editores.php_;_
clave_:_ proyecto,solicitud_obs_tipo_;_
valor_:_ descripcion_;_
no_seteado_:_ NO clasificar_;_
', '23', 'ACCESO - Clasificar', NULL, 'Categorizacion pensada para navegar facilmente los LOGS.', '1', NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1519', 'solicitud_observacio', 'ef_editable_multilinea', 'solicitud_observacion', NULL, 'filas_:_ 4_;_
columnas_:_ 55_;_
', '24', 'ACC. - Obs.', NULL, 'Observacion sobre el acceso a este item.', '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1520', 'solicitud_registrar', 'ef_checkbox', 'solicitud_registrar', NULL, 'valor_:_ 1_;_
', '22', 'ACCESO - Registrar', NULL, 'Registrar el acceso a este ITEM', '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1521', 'solicitud_registrar_', 'ef_checkbox', 'solicitud_registrar_cron', NULL, 'valor_:_ 1_;_
', '25', 'ACC - Cronom.', NULL, 'Cronometrar el acceso al ITEM', '1', NULL, NULL, NULL);
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1522', 'solicitud_tipo', 'ef_combo', 'solicitud_tipo', NULL, 'predeterminado_:_ web_;_
sql_:_ SELECT solicitud_tipo, descripcion_corta 
FROM apex_solicitud_tipo 
WHERE solicitud_tipo <> \'fantasma\'
ORDER BY 1_;_
', '4', 'Tipo de solicitud', NULL, 'El [wiki:Referencia/Solicitud Tipo de Solicitud] marca desde que ambiente se puede solicitar el item y que clases/funciones habr� disponible para esa ejecuci�n. Usualmente son solicitudes Web.', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1523', 'zona', 'ef_combo', 'zona_proyecto, zona', NULL, 'dao_:_ get_zonas_;_
clase_:_ dao_editores_;_
include_:_ db/dao_editores.php_;_
clave_:_ proyecto,zona_;_
valor_:_ nombre_;_
no_seteado_:_ Ninguna_;_
', '19', 'ZONA', NULL, 'Zona de la que el ITEM forma parte', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1524', 'zona_listar', 'ef_checkbox', 'zona_listar', NULL, 'valor_:_ 1_;_
', '20', 'Zona - listar', NULL, 'Listar el ITEM como vecino de la ZONA?', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1525', 'zona_orden', 'ef_editable_numero', 'zona_orden', NULL, '_;_
', '21', 'ZONA - Orden', NULL, 'Orden que ocupa el item en la zona', NULL, NULL, NULL, '0');
INSERT INTO apex_objeto_ei_formulario_ef (objeto_ei_formulario_proyecto, objeto_ei_formulario, objeto_ei_formulario_fila, identificador, elemento_formulario, columnas, obligatorio, inicializacion, orden, etiqueta, etiqueta_estilo, descripcion, colapsado, desactivado, estilo, total) VALUES ('admin', '1519', '1526', 'comportamiento', 'ef_combo', 'comportamiento', NULL, 'lista_:_ patron/Predefinido,accion/Script PHP en sistema de archivos,buffer/Script PHP en fuente de datos_;_
', '8', 'Tipo Comportamiento', NULL, 'El comportamiento determina la ejecuci�n principal de la operaci�n. Generalmente instancia los objetos involucrados y les asigna un rol espec�fico.', NULL, NULL, NULL, '0');
