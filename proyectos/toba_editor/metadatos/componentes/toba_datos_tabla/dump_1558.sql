------------------------------------------------------------
--[1558]--  ITEM - Objetos Asociados 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'toba_editor', --proyecto
	'1558', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'12', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'ITEM - Objetos Asociados', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'toba_editor', --fuente_datos_proyecto
	'instancia', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2005-09-06 17:01:14', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'12', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'apex_item_objeto', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'1', --modificar_claves
	'toba_editor', --fuente_datos_proyecto
	'instancia', --fuente_datos
	'1', --permite_actualizacion_automatica
	NULL, --esquema
	NULL  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'269', --col_id
	'proyecto', --columna
	'C', --tipo
	'1', --pk
	NULL, --secuencia
	'15', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'270', --col_id
	'item', --columna
	'C', --tipo
	'1', --pk
	NULL, --secuencia
	'60', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'271', --col_id
	'objeto', --columna
	'E', --tipo
	'1', --pk
	NULL, --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'272', --col_id
	'orden', --columna
	'E', --tipo
	'0', --pk
	NULL, --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'273', --col_id
	'inicializar', --columna
	'E', --tipo
	'0', --pk
	NULL, --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'274', --col_id
	'clase', --columna
	'C', --tipo
	'0', --pk
	NULL, --secuencia
	'60', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'1', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'275', --col_id
	'nombre_objeto', --columna
	'C', --tipo
	'0', --pk
	NULL, --secuencia
	'60', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'1', --externa
	NULL  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'276', --col_id
	'descripcion', --columna
	'C', --tipo
	'0', --pk
	NULL, --secuencia
	'60', --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'1', --externa
	NULL  --tabla
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros_ext
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_ext (objeto_proyecto, objeto, externa_id, tipo, sincro_continua, metodo, clase, include, punto_montaje, sql, dato_estricto, carga_dt, carga_consulta_php, permite_carga_masiva, metodo_masivo) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'2', --externa_id
	'dao', --tipo
	'1', --sincro_continua
	'get_info_dependencia', --metodo
	'toba_info_editores', --clase
	'modelo/info/toba_info_editores.php', --include
	NULL, --punto_montaje
	NULL, --sql
	'1', --dato_estricto
	NULL, --carga_dt
	NULL, --carga_consulta_php
	'0', --permite_carga_masiva
	NULL  --metodo_masivo
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros_ext_col
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'2', --externa_id
	'269', --col_id
	'0'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'2', --externa_id
	'271', --col_id
	'0'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'2', --externa_id
	'274', --col_id
	'1'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'2', --externa_id
	'275', --col_id
	'1'  --es_resultado
);
INSERT INTO apex_objeto_db_registros_ext_col (objeto_proyecto, objeto, externa_id, col_id, es_resultado) VALUES (
	'toba_editor', --objeto_proyecto
	'1558', --objeto
	'2', --externa_id
	'276', --col_id
	'1'  --es_resultado
);
