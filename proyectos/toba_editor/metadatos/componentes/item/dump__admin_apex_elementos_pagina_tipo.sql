------------------------------------------------------------
--[/admin/apex/elementos/pagina_tipo]--  Tipo de PAGINA 
------------------------------------------------------------
INSERT INTO apex_item (item_id, proyecto, item, padre_id, padre_proyecto, padre, carpeta, nivel_acceso, solicitud_tipo, pagina_tipo_proyecto, pagina_tipo, actividad_buffer_proyecto, actividad_buffer, actividad_patron_proyecto, actividad_patron, nombre, descripcion, actividad_accion, menu, orden, solicitud_registrar, solicitud_obs_tipo_proyecto, solicitud_obs_tipo, solicitud_observacion, solicitud_registrar_cron, prueba_directorios, zona_proyecto, zona, zona_orden, zona_listar, imagen_recurso_origen, imagen, parametro_a, parametro_b, parametro_c, publico, redirecciona, usuario, creacion) VALUES ('182', 'toba_editor', '/admin/apex/elementos/pagina_tipo', '177', 'toba_editor', '/configuracion', '0', '0', 'web', 'toba', 'titulo', 'toba', '0', 'toba', 'abms_cuadro_proyecto', 'Tipo de PAGINA', 'Los [wiki:Referencia/TipoPagina tipos de p�gina] determinan la salida anterior y posterior a las pantallas de una operaci�n. Cada [wiki:Referencia/Item �tem] tiene un tipo de p�gina asociado.', '', '1', '10', '0', NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, '0', 'apex', 'tipo_pagina.gif', NULL, NULL, NULL, '0', '0', NULL, '2004-04-12 14:52:51');
INSERT INTO apex_item_objeto (item_id, proyecto, item, objeto, orden, inicializar) VALUES (NULL, 'toba_editor', '/admin/apex/elementos/pagina_tipo', '1835', '0', NULL);
