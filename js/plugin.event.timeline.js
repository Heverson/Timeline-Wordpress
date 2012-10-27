window.onload = function(){

	/* ==========================================================
	 * Cadastro de Eventos
	 * ========================================================== */

	 // ativa o datePicker 
	translateDatePicker('.f-startdate, .f-enddate');

	// Cria o objeto
	var event_timeline = new CreateEventsTimeline();

	//seta os valores do formulário
	event_timeline._headline 			= jQuery('.headline');
	event_timeline._id_timeline 		= jQuery('.id_timeline');
	event_timeline._id_eventotimeline 	= (jQuery('.id_eventotimeline').val().length > 0) ? jQuery('.id_eventotimeline') : "";
	event_timeline._start_date 			= jQuery('.start_date');
	event_timeline._end_date 			= jQuery('.end_date');
	event_timeline._media 				= jQuery('.midia');
	event_timeline._credit 				= jQuery('.assets_credit');
	event_timeline._caption 			= jQuery('.assets_caption');
	event_timeline._text 				= jQuery('.description_text');
	event_timeline._action 				= jQuery('.acao');
	
	console.log(event_timeline._media);
	console.log(event_timeline._text);
	console.log(event_timeline._headline);

	// verifica se é alteração ou cadastro
	if (jQuery('.id_eventotimeline').val().length > 0)
		event_timeline._msn = "Evento alterado com sucesso!";
	else
		event_timeline._msn = "Evento cadastrado com sucesso!";

	// se passou para a validação submete o formulário 
	jQuery('.btn-submit').click(function(){
		if(event_timeline.validate() == true){
			event_timeline.submitForm();	
		};
	});
			
	// escuta o evento do checkbox de mídia
	document.getElementById('exibir_media').addEventListener('click', function(){
		jQuery('#media-event .grid-300, #midia-library').toggle();
	});

	
}	




