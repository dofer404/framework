//--------------------------------------------------------------------------------
//Clase ef_popup
ef_popup.prototype = new ef;
var def = ef_popup.prototype;
def.constructor = ef_popup;

	function ef_popup(id_form, etiqueta, obligatorio, colapsado) {
		ef.prototype.constructor.call(this, id_form, etiqueta, obligatorio, colapsado);
		this.elementos = new Array();
		this.elementos_cant = 0;		
	}

	def.validar = function () {
		if (this._obligatorio && ereg_nulo.test(this.valor())) {
			this._error = 'El campo ' + this._etiqueta + ' es obligatorio.';
		    return false;
		}
		return true;
	}

	def.seleccionar = function () {
		if (this.vinculo())
			this.vinculo().focus();
	}
		
	def.tab = function () {
		if (this.vinculo())
			return this.vinculo().tabIndex;
	}
			
	def.cambiar_tab = function(tab_index) {
		if (this.vinculo())
			this.vinculo().tabIndex = tab_index;
	}	
	
	def.valor_formateado = function() {
		return document.getElementById(this._id_form + '_desc').value;
	}
	
	def.vinculo = function () {
		return document.getElementById(this._id_form + '_vinculo');		
	}

//--------------------------------------------------------------------------------
//Funciones varias

var popup_elementos = new Array();

function popup_abrir_item(url, indice, elemento_cod, elemento_desc, parametros_ventana)
{
	popup_elementos.push(new Array(indice, elemento_cod, elemento_desc));
	//-- Seteo parametros de la ventana
	if(parametros_ventana !== null){
		vars = "width=" + parametros_ventana[0] + ",height=" + parametros_ventana[1] + ",scrollbars=" + parametros_ventana[2] +  ",dependent=yes";
	}else{
		vars = ""
	}
	//-- Abro la ventana
	if (!window.popup_hija){
		// No fue definida.
		popup_hija = window.open( url , 'popup_hija', vars);
		popup_hija.opener = window;
		popup_hija.focus();
	} else {
		// Ya fue definida.
		if(!popup_hija.closed){
			//Todavia esta abierta
			popup_hija.opener = window;
			popup_hija.location.href = url;
			popup_hija.focus();
		}else{
			popup_hija = window.open( url , 'popup_hija', vars);
		}
	}
	return popup_hija;
}

function popup_callback(indice, clave, desc)
{
	for (i in popup_elementos) {
		if (popup_elementos[i][0] == indice) {
			encontrado=true;
			popup_elementos[i][1].value = clave;
			if (popup_elementos[i][1].onchange)
				popup_elementos[i][1].onchange();
			popup_elementos[i][2].value = desc;	
		}			
	}		

}
	