<?php
	$proyecto = toba::proyecto()->get_parametro('descripcion');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title><?php echo $proyecto ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<frameset rows="*" cols="380,*" frameborder="YES" border="1" bordercolor="#553DA1" framespacing="0" id='frameset_admin'>
  <frameset rows="59,*" frameborder="YES" border="1"  bordercolor="#553DA1" framespacing="0">
    <frame src="<?php echo toba::vinculador()->generar_solicitud(toba_editor::get_id(),'/admin/menu_principal')?>" name="<?php echo  apex_frame_control ?>" scrolling="NO">
    <frame src="<?php echo toba::vinculador()->generar_solicitud(toba_editor::get_id(),'/admin/items/catalogo_unificado',null,false,false,null,true,'lateral')?>" name="<?php echo  apex_frame_lista ?>" scrolling="auto">
  </frameset>
  <frame src="<?php echo toba::vinculador()->generar_solicitud(toba_editor::get_id(),'/inicio')?>" name="<?php echo  apex_frame_centro ?>" scrolling="auto">
</frameset>

</html>
