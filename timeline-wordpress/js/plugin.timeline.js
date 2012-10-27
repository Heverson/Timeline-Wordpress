window.onload = function(){

	// verifica se a mídia está marcada, e mostra os campos
	if (jQuery('input:checked').length === 1) { jQuery('#media-event .grid-300').show()};

	// adiciona a imagem da biblioteca na mídia
	jQuery('.addimg-media').click(function() {
		var guid = jQuery(this).data('mediaimg');
		if(jQuery('.midia').val().length > 0){ 
			alert("Esse campo permite só um registro.\n\n Se quiser adicionar outra informação apague a anterior.");
			return false;
		}
		else{
			jQuery('.midia').val(guid);
		}
	});

	/* ==========================================================
	 * Cadastro de Timeline
	 * ========================================================== */

	// ativa o datePicker 
	translateDatePicker('.f-startdate');
	
	jQuery('#form_create').delegate('.f-btn', 'click', function(){
		
		var create_timeline =  new CreateTimeline();

		// seta os valores dos inputs nas variáveis
		create_timeline._el 			= jQuery('#f-content_form');
		create_timeline._form 			= jQuery('#form_create');
		create_timeline._headline 		= jQuery('.f-headline');
		create_timeline._text 			= jQuery('.f-description');
		create_timeline._startDate 		= jQuery('.f-startdate');
		create_timeline._type 			= jQuery('.f-type');
		create_timeline._datacadastro 	= jQuery('.f-datacadastro');
		create_timeline._id_timeline	= jQuery('.f-id_timeline').val();
		// aplica as validações		
		if(create_timeline.validate())
		{
			// valida a data para inteiro
			var datas  = jQuery(create_timeline._startDate).val().split("/");

			// monta a data de (10/09/2012) para (20120910)	
			create_timeline._startDate = datas[2];

			// submete o formulário via Ajax
			create_timeline.submitForm();
		}
	})

	
}	




