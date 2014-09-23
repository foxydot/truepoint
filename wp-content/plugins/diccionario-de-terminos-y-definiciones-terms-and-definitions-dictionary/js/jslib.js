jQuery(document).ready(function($){
	var myOptions = {
	    // Podemos declarar un color por defecto aquí
	    // o en el atributo del input data-default-color
	    defaultColor: false,
	    // llamada que se lanzará cuando el input tenga un color válido
	    change: function(event, ui){},
	    // llamada que se lanzará cuando el input tenga un color no válido
	    clear: function() {},
	    // esconde los controles del Color Picker al cargar
	    hide: true,
	    // muestra un grupo de colores comunes debajo del selector 
	    // o suministra de una gama de colores para poder personalizar más aun.
	    palettes: true
	};
    $('.def-wp-color-field').wpColorPicker(myOptions);
});