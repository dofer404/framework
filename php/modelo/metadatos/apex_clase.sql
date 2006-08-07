INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto', '4', 'nucleo/componentes/objeto.php', 'Ancestro de todos los objetos que pueden crearse en la libreria', 'Objeto APEX', 'objetos/fantasma.gif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', 'no', 'objetos/objeto_clase.png', 'objetos/objeto_der.png', 'sql/pgsql_a01_nucleo.sql', NULL, '1', NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ci', '8', 'nucleo/componentes/interface/objeto_ci.php', 'Controlador de Interface', 'Controlador de Interface', 'objetos/multi_etapa.gif', NULL, 'toba', 'objeto_ci', NULL, 'toba_editor', '1642', NULL, 'toba_editor', '/admin/objetos_toba/editores/ci', NULL, NULL, 'apex_objeto_mt_me: objeto_mt_me;
apex_objeto_ci_pantalla: objeto_ci;
apex_objeto_eventos: objeto;', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_cn', '5', 'nucleo/componentes/negocio/objeto_cn.php', 'Objeto de Negocio', 'Objeto de Negocio', 'objetos/negocio.gif', NULL, 'toba', 'objeto', NULL, NULL, NULL, NULL, 'toba_editor', '2045', NULL, NULL, 'aaa', 'aa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_cuadro', '2', 'nucleo/componentes/transversales/objeto_cuadro.php', 'CUADRO', 'CUADRO', 'objetos/cuadro.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/cuadro', NULL, 'toba_editor', '/admin/objetos/editores/cuadro', NULL, NULL, 'apex_objeto_cuadro: objeto_cuadro;
apex_objeto_cuadro_columna: objeto_cuadro;', 'no', NULL, NULL, NULL, '1', '1', NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_cuadro_reg', '2', 'nucleo/componentes/transversales/objeto_cuadro_reg.php', 'Objeto cuadro (muestra columnas como filas)', 'objeto_cuadro_reg', 'objetos/cuadro2.gif', NULL, 'toba', 'objeto_cuadro', NULL, 'toba_editor', '/admin/objetos/instanciadores/cuadro_reg', NULL, 'toba_editor', '/admin/objetos/editores/cuadro_reg', NULL, NULL, 'a', 'a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_datos_relacion', '9', 'nucleo/componentes/persistencia/objeto_datos_relacion.php', 'Objeto DATOS - RELACION', 'Objeto DATOS - RELACION', 'objetos/datos_relacion.gif', NULL, 'toba', 'objeto', NULL, NULL, NULL, NULL, 'toba_editor', '/admin/objetos_toba/editores/db_tablas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_datos_tabla', '9', 'nucleo/componentes/persistencia/objeto_datos_tabla.php', 'Objeto DATOS - TABLA', 'Objeto DATOS - TABLA', 'objetos/datos_tabla.gif', NULL, 'toba', 'objeto', NULL, NULL, NULL, NULL, 'toba_editor', '/admin/objetos_toba/editores/db_registros', NULL, NULL, 'apex_objeto_db_registros: objeto;
apex_objeto_db_registros_col: objeto;', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei', '7', 'nucleo/componentes/interface/objeto_ei.php', 'Elemento de interface', 'aa', 'objetos/fantasma.gif', NULL, 'toba', 'objeto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd', 'd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_arbol', '7', 'nucleo/componentes/interface/objeto_ei_arbol.php', 'Muestra una estructura en forma de arbol permitiendo colapsar distintas ramas, anexar iconos, utilerias y  propiedades a cada uno de los distintos nodos.', 'objeto_ei_arbol', 'objetos/arbol.gif', NULL, 'toba', 'objeto_ei', NULL, NULL, NULL, NULL, 'toba_editor', '1241', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_archivos', '7', 'nucleo/componentes/interface/objeto_ei_archivos.php', 'Muestra archivos y directorios.', 'Muestra archivos y directorios', 'objetos/archivos.gif', NULL, 'toba', 'objeto_ei', NULL, NULL, NULL, NULL, 'toba_editor', '/admin/objetos_toba/editores/ei_archivos', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_calendario', '7', 'nucleo/componentes/interface/objeto_ei_calendario.php', 'Calendario que permite la selecci�n de d�as y semanas', 'objeto_ei_calendario', 'objetos/calendario.gif', NULL, 'toba', 'objeto_ei', NULL, NULL, NULL, NULL, 'toba_editor', '2447', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_cuadro', '7', 'nucleo/componentes/interface/objeto_ei_cuadro.php', 'Objeto cuadro que carga su contenido a partir de un ARRAY', 'Cuadro Array', 'objetos/cuadro_array.gif', NULL, 'toba', 'objeto_ei', NULL, 'toba_editor', '1843', NULL, 'toba_editor', '/admin/objetos_toba/editores/ei_cuadro', NULL, NULL, 'apex_objeto_cuadro: objeto_cuadro;
apex_objeto_ei_cuadro_columna: objeto_cuadro;
apex_objeto_eventos: objeto;', 'd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_esquema', '7', 'nucleo/componentes/interface/objeto_ei_esquema.php', 'Muestra grafos utilizando GraphViz', 'objeto_ei_esquema', 'objetos/esquema.gif', NULL, 'toba', 'objeto_ei', NULL, NULL, NULL, NULL, 'toba_editor', '2865', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_filtro', '7', 'nucleo/componentes/interface/objeto_ei_filtro.php', 'Formulario para filtro, provee un evento: filtrar', 'EI - filtro', 'objetos/ut_formulario.gif', NULL, 'toba', 'objeto_ei_formulario', NULL, 'toba_editor', '1842', NULL, 'toba_editor', '/admin/objetos_toba/editores/ei_filtro', NULL, NULL, 'apex_objeto_ut_formulario: objeto_ut_formulario;
apex_objeto_ei_formulario_ef: objeto_ei_formulario;
apex_objeto_eventos: objeto;', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_formulario', '7', 'nucleo/componentes/interface/objeto_ei_formulario.php', 'Representa un formulario de datos', 'Formulario', 'objetos/ut_formulario.gif', NULL, 'toba', 'objeto_ei', NULL, 'toba_editor', '1842', NULL, 'toba_editor', '/admin/objetos_toba/editores/ei_formulario', NULL, NULL, 'apex_objeto_ut_formulario: objeto_ut_formulario;
apex_objeto_ei_formulario_ef: objeto_ei_formulario;
apex_objeto_eventos: objeto;', 'ff', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ei_formulario_ml', '7', 'nucleo/componentes/interface/objeto_ei_formulario_ml.php', 'Elemento de formulario multilinea', 'EI Formulario Multilinea', 'objetos/ut_formulario_ml.gif', NULL, 'toba', 'objeto_ei_formulario', NULL, 'toba_editor', '1842', NULL, 'toba_editor', '/admin/objetos_toba/editores/ei_formulario_ml', NULL, NULL, 'apex_objeto_ut_formulario: objeto_ut_formulario;
apex_objeto_ei_formulario_ef: objeto_ei_formulario;
apex_objeto_eventos: objeto;', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_filtro', '2', 'nucleo/componentes/transversales/objeto_filtro.php', 'FILTRO', 'FILTRO', 'objetos/filtro.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/filtro', NULL, 'toba_editor', '/admin/objetos/editores/filtro', NULL, NULL, 'apex_objeto_filtro: objeto_filtro;', 'c', 'objetos/objeto_filtro_clase.png', 'objetos/objeto_filtro_der.png', 'sql/pgsql_a02_dimensiones.sql, sql/pgsql_a11_clase_filtro.sql', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_hoja', '2', 'nucleo/componentes/transversales/objeto_hoja.php', 'HOJA de DATOS', 'HOJA de DATOS', 'objetos/hoja.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/hoja', NULL, 'toba_editor', '/admin/objetos/editores/hoja', NULL, NULL, 'apex_objeto_hoja: objeto_hoja;
apex_objeto_hoja_directiva : objeto_hoja;', 'SELECT * FROM apex_objeto_hoja;', 'objetos/objeto_hoja_clase.png', 'objetos/objeto_hoja_der.png', 'sql/pgsql_a10_clase_hoja.sql', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_html', '1', 'nucleo/componentes/transversales/objeto_html.php', 'HTML estatico', 'Objeto HTML', 'objetos/html.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/html', NULL, 'toba_editor', '/admin/objetos/editores/html', NULL, NULL, 'apex_objeto_html: objeto_html;', 'l', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_lista', '2', 'nucleo/componentes/transversales/objeto_lista.php', 'LISTA', 'LISTA', 'objetos/lista.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/lista', NULL, 'toba_editor', '/admin/objetos/editores/lista', NULL, NULL, 'apex_objeto_lista: objeto_lista;', 'jkl', 'objetos/objeto_lista_clase.png', 'objetos/objeto_lista_der.png', 'sql/pgsql_a14_clase_lista.sql', '1', NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_mapa', '2', 'nucleo/componentes/transversales/objeto_mapa.php', 'Clase para generar mapas', 'Mapa', 'zona.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/mapa', NULL, 'toba_editor', '/admin/objetos/editores/mapa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_mt', '3', 'nucleo/componentes/transversales/objeto_mt_s.php', 'Clase Abstracta de la que heredan todos los marcos transaccionales', 'Marco Transaccional', 'objetos/mt.gif', NULL, 'toba', 'objeto', NULL, 'toba_editor', '/admin/objetos/instanciadores/mt', NULL, NULL, NULL, NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_mt_abms', '2', 'nucleo/componentes/transversales/objeto_mt_s_abm.php', 'Implementacion de un ABM simple', 'ABM Simple', 'objetos/abms.gif', NULL, 'toba', 'objeto_mt', NULL, 'toba_editor', '/admin/objetos/instanciadores/abms', NULL, 'toba_editor', '/admin/objetos/editores/abms', NULL, NULL, 'apex_objeto_ut_formulario: objeto_ut_formulario;
apex_objeto_ut_formulario_ef: objeto_ut_formulario;', 'aa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_mt_mds', '3', 'nucleo/componentes/transversales/objeto_mt_s_md.php', 'Marco Transaccional basico', 'MT maestro-detalle', 'objetos/mt_mds.gif', NULL, 'toba', 'objeto_mt', NULL, 'toba_editor', '/admin/objetos/instanciadores/mt_mds', NULL, NULL, NULL, NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_mt_me', '3', 'nucleo/componentes/transversales/objeto_mt_me.php', 'Marco transaccional multi-etapa', 'Mt - Multi etapa', 'objetos/multi_etapa.gif', NULL, 'toba', 'objeto_mt', NULL, 'toba_editor', '/admin/objetos/instanciadores/mt_me', NULL, 'toba_editor', '/admin/objetos/editores/mt_me', NULL, NULL, 'll', 'll', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_mt_s', '3', 'nucleo/componentes/transversales/objeto_mt_s.php', 'Marco transaccional de una sola etapa', 'Marco transaccional simple', 'objetos/mt.gif', NULL, 'toba', 'objeto_mt', NULL, 'toba_editor', '/admin/objetos/instanciadores/mt', NULL, NULL, NULL, NULL, NULL, 'd', 'd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ut', '6', 'nucleo/componentes/transversales/objeto_ut.php', 'Representa un elemento que se puede utilizar para generar una transaccion en la base', 'Unidad transaccional', 'objetos/ut.gif', NULL, 'toba', 'objeto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no', 'no', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL);
INSERT INTO apex_clase (proyecto, clase, clase_tipo, archivo, descripcion, descripcion_corta, icono, screenshot, ancestro_proyecto, ancestro, instanciador_id, instanciador_proyecto, instanciador_item, editor_id, editor_proyecto, editor_item, editor_ancestro_proyecto, editor_ancestro, plan_dump_objeto, sql_info, doc_clase, doc_db, doc_sql, vinculos, autodoc, parametro_a, parametro_b, parametro_c, exclusivo_toba) VALUES ('toba', 'objeto_ut_formulario', '6', 'nucleo/componentes/transversales/objeto_ut_formulario.php', 'Unidad transaccional que representa un formulario relacionado con una trabla', 'UT Formulario', 'objetos/ut_formulario.gif', NULL, 'toba', 'objeto_ut', NULL, 'toba_editor', '/admin/objetos/instanciadores/ut_formulario', NULL, 'toba_editor', '/admin/objetos/editores/ut_formulario', NULL, NULL, 'apex_objeto_ut_formulario: objeto_ut_formulario;
apex_objeto_ut_formulario_ef: objeto_ut_formulario;', 'no', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL);
