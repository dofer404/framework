------------------------------------------------------------
--[/prueba_efs]--  Prueba efs 
------------------------------------------------------------

------------------------------------------------------------
-- apex_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 1
INSERT INTO apex_item (item_id, proyecto, item, padre_id, padre_proyecto, padre, carpeta, nivel_acceso, solicitud_tipo, pagina_tipo_proyecto, pagina_tipo, actividad_buffer_proyecto, actividad_buffer, actividad_patron_proyecto, actividad_patron, nombre, descripcion, actividad_accion, menu, orden, solicitud_registrar, solicitud_obs_tipo_proyecto, solicitud_obs_tipo, solicitud_observacion, solicitud_registrar_cron, prueba_directorios, zona_proyecto, zona, zona_orden, zona_listar, imagen_recurso_origen, imagen, parametro_a, parametro_b, parametro_c, publico, redirecciona, usuario, creacion) VALUES (
	'1000006', --item_id
	'toba_testing', --proyecto
	'/prueba_efs', --item
	NULL, --padre_id
	'toba_testing', --padre_proyecto
	'__raiz__', --padre
	'1', --carpeta
	'0', --nivel_acceso
	NULL, --solicitud_tipo
	'toba', --pagina_tipo_proyecto
	'NO', --pagina_tipo
	'toba', --actividad_buffer_proyecto
	'0', --actividad_buffer
	'toba', --actividad_patron_proyecto
	'generico', --actividad_patron
	'Prueba efs', --nombre
	NULL, --descripcion
	NULL, --actividad_accion
	'1', --menu
	NULL, --orden
	NULL, --solicitud_registrar
	NULL, --solicitud_obs_tipo_proyecto
	NULL, --solicitud_obs_tipo
	NULL, --solicitud_observacion
	NULL, --solicitud_registrar_cron
	NULL, --prueba_directorios
	NULL, --zona_proyecto
	NULL, --zona
	NULL, --zona_orden
	NULL, --zona_listar
	NULL, --imagen_recurso_origen
	NULL, --imagen
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --publico
	NULL, --redirecciona
	NULL, --usuario
	'2006-05-15 09:12:30'  --creacion
);
--- FIN Grupo de desarrollo 1