// Requisição via AMD
if ( typeof define == 'function' && define.amd ) {
	define([], function() {
		return {
			start: textCounter.CONSTRUCTOR
		};
	});
}
// Requisição normal
else{
	jQuery(document).ready(function( jQuery ) {
		// Declara $ para evitar conflito
		$ = jQuery;
		textCounter.CONSTRUCTOR();
	});
}

var textCounter = {},
objects = {};

// Construtor
textCounter.CONSTRUCTOR = function(el){
    objects.baseNameUrl = baseNameUrl;
    var dataEl = jQuery.find("[data-limit]");
    
    var groupId = $('#jform_id_testimonials_group').val();
    
    // Dados enviados para a requisição.
    

    var controller = 'testimonial';
    var vFunction = 'getGroupCharacterLimitAjax';
    var task = controller + '.' + vFunction;
    var url = baseNameUrl + 'administrator/index.php?option=com_nobosstestimonials&task=' + task;

    $('#jform_id_testimonials_group').on('change', function(){
        var data = {
            groupId: $(this).val()
        };
        // Envia requisição ajax com o id do grupo
        jQuery.ajax({
            type: 'POST',
            url: url,
            data: data,
            cache: false
        }).done(function(response){
           //pega o elemento que engloba o textcounter
           var counterElementWrapper = $(".nobosstextcounter-wrapper");
           //seta o limit do grupo atual no counter
           $(counterElementWrapper).data("limit", response);
           //reseta o listener
           $(textAreaElement).off("input");
           //pega o textarea
           var textAreaElement = $(counterElementWrapper).siblings("textarea");
           //pega a forma de exibir os caracteres
           var showCharacters = $(counterElementWrapper).data("showcharacters");
           //coloca outro listener para atualizar os valores
           listener(counterElementWrapper, showCharacters);
           //adapta o texto existente para ter o tamanho do limite
           jQuery(textAreaElement).val(jQuery(textAreaElement).val().substring(0, response));
        });
    });
    
};
