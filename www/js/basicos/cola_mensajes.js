/**
*	Clase para manejo de mensajer�a al usuario
**/
window.status = '';
var cola_mensajes = 
{
	_mensajes: [],
	_responsable: null,
	
	agregar: function(mensaje, gravedad, sujeto) {
		if (!gravedad) {gravedad = 'error';}
		this._mensajes.push([mensaje, gravedad, sujeto]);
	},	

	mostrar : function(responsable) {
		if (this._mensajes.length > 0) {
			if (responsable) {
				this._responsable = responsable;
				responsable.notificar(true);
			}
			this.ventana_modal();
		}
	},
	
	limpiar: function() {
		this._mensajes = [];
		if (this._responsable) {
			this._responsable.notificar(false);
		}
	},
	
	ventana_modal: function() {
		var contenedor = document.getElementById('overlay_contenido');
		if (!contenedor) {
			//--- Si el mensaje se produce antes del body, usar el alert
			this.ventana_alert();
			return;	
		}
		var mensaje = '<div class="overlay-titulo">Se han encontrado los siguientes problemas:</div>';
		for (var i=0; i < this._mensajes.length; i++) {
			var gravedad = '';
			if (this._mensajes[i][1] == 'error') {
				gravedad = '<img src="'+ toba.imagen('error') + '"/> ';
			}
			var texto = this._mensajes[i][0];
			if (typeof this._mensajes[i][2] != 'undefined') {
				texto = "<strong>" + this._mensajes[i][2] + "</strong> " + texto;
			}
			mensaje += '<div>' + gravedad + texto + '</div>';
		}
		mensaje += "<div class='overlay-botonera'><input id='boton_overlay' type='button' value='Aceptar' onclick='overlay()'/></div>";
		contenedor.innerHTML = mensaje;
		overlay();
	},
	
	ventana_alert: function() {
		var mensaje = '';
		var hay_error = false;
		var hay_info = false;
		for (var i=0; i < this._mensajes.length; i++) {
			var gravedad;
			if (this._mensajes[i][1] == 'error') {
				gravedad = '- ';
				hay_error = true;
			}
			else {
				gravedad = '- ';
				hay_info = true;
			}
			var texto = this._mensajes[i][0];
			if (typeof this._mensajes[i][2] != 'undefined') {
				texto = this._mensajes[i][2] + " " + texto;
			}			
			mensaje += gravedad + texto + '\n';
		}
		var encabezado = (hay_error) ? 'Se han encontrado los siguientes problemas:\n\n' : 'Atenci�n:\n\n';
		alert(encabezado + mensaje);
	}
};

function overlay() {
	el = document.getElementById("overlay");
	var visible = (el.style.visibility == "visible");
	if (ie) {
		//--- Oculta los SELECT por bug del IE
		var selects = document.getElementsByTagName('select');
		for (var i=0; i < selects.length; i++) {
			selects[i].style.visibility = (visible) ? 'visible' : 'hidden';	
		}
	}
	el.style.visibility = (visible) ? "hidden" : "visible";
	if (! visible) {
		var boton = document.getElementById('boton_overlay');
		if (boton) {
			boton.focus();
			window.firstFocus = function() {};
		}
	}
}

toba.confirmar_inclusion('basicos/cola_mensajes');