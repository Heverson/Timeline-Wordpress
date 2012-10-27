/**
* Ação em Massa
*/
function ActioninMass(){

	var id_name; 
	var id_reg = [];
	var action_url;
	var form;

	this.actionEdit = function(){
		location.href="admin.php?page=listar-timeline&action="+this.action_url+"&"+this.id_name+"="+this.id_reg[0];	
	};

	this.actionDelete = function(){
		jQuery.ajax({
		  type: 'GET',
		  dataType: 'json',
		  data: {action: this.action_url, id : this.id_reg},
		  complete: function(xhr, textStatus) {
		    //called when complete
		  },
		  success: function(data, textStatus, xhr) {
		    //called when successful
		  },
		  error: function(xhr, textStatus, errorThrown) {
		    //called when there is an error
		  }
		});
		
	};
}

/**
* Cadastro de Timeline
*/
function CreateTimeline() {
	
	// variáveis do formulário
	var _headline;
	var _startDate;
	var _type;
	var _datacadastro;
	var _text;
	var _form;
	var _action;
	var _el;
	var _id_timeline = "";
	var _ativo = 1;
	
	this.validate = function(){
		
		if (jQuery(this._headline).val().length == 0) {
			alert('Ops, Preenchar o Titulo da Timeline!');
			jQuery(this._headline).focus();
			return false;
		}
		else if(jQuery(this._startDate).val().length == 0){
			alert('Ops, Preencha a Data de Inicio da Timeline!');
			jQuery(this._startDate).focus();
			return false;	
		}
		else if (jQuery(this._text).val().length == 0) {
			alert('Ops, Preenchar a Descrição da Timeline!');
			jQuery(this._text).focus();
			return false;
		}
		else{
			return true;
		}
	};

	this.submitForm = function(){
		
		jQuery.ajax({
		  type: 'GET',
		  dataType: 'json',
		  data: {	'HEADLINE': jQuery(this._headline).val(), 
		  			'TEXT': jQuery(this._text).val() ,
		  			'TYPE': jQuery(this._type).val() ,
		  			'DATACADASTRO': jQuery(this._datacadastro).val() ,
		  			'STARTDATE': this._startDate ,
		  			'ATIVO': this._ativo ,
		  			'id_timeline': (this._id_timeline != "") ? this._id_timeline : "",
		  			'insert_timeline': 1
			},
			complete:function(){
				location.href="?page=listar-timeline";
			}
		});
	}
}

/**
* Transforma a data em Inteiro
* remove '/' e formata para anomêsdia (Ymd)
*/
function dateToInt(data){
	var data_f = data.split('/');
	return data_f[2]+data_f[1]+data_f[0];
}

/**
* Traduz e extancia o calendário datepicker
*/
function translateDatePicker(obj){
jQuery(obj).datepicker({
		dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: [  'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro', 'Outubro','Novembro','Dezembro'], 
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set', 'Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior'
	}); 
}


/**
* Cadastro de Timeline
*/
function CreateEventsTimeline(){

	// variáveis do formulário
   var _headline;
   var _id_timeline;
   var _start_date;
   var _end_date;
   var _media;
   var _credit ;
   var _caption;
   var _text;
   var _acao;
   var _id_eventotimeline; 
   var _msn;
   var _ativo = 1;
	
	/**
	 * validação
	 * - campos não nulos (titulo, datainicial)
	 * - data inicial < datafinal 
	 */	
	
	this.validate = function(){
		var rtn = true;

		if (jQuery(this._headline).val().length == 0) {
			alert('Ops, Preenchar o Titulo da Timeline!');
			rtn = false;
		};
		
		if (jQuery(this._start_date).val().length == 0){
			alert('Ops, Preenchar pelo menos a Data Inicial do seu evento!', jQuery(this._start_date).val(), jQuery(this._end_date).val());
			jQuery(this._start_date).focus();
			rtn = false;
		};

		// validação das datas
		if (jQuery(this._end_date).val().length > 0) {
			if ( dateToInt( jQuery(this._start_date).val() ) > dateToInt( jQuery(this._end_date).val() ) ) 
			{
				alert('Ops, Você preencheu a Data Inicial maior que a Data Final');
				jQuery(this._start_date).focus();
				rtn = false;
			};
		};
		return rtn;
	};

	this.submitForm = function(){
		
		jQuery.ajax({
		  type: 'GET',
		  dataType: 'json',
		  data: {	'ID_TIMELINE': jQuery(this._id_timeline).val() ,
		  			'ID_EVENTOTIMELINE' : jQuery(this._id_eventotimeline).val(),
		  			'headline': jQuery(this._headline).val(), 
		  			'text': jQuery(this._text).val() ,
		  			'startDate': dateToInt( jQuery(this._start_date).val() ) ,
		  			'endDate': dateToInt( jQuery(this._end_date).val() ) ,
		  			'media': jQuery(this._media).val() ,
		  			'credit': jQuery(this._credit).val() ,
		  			'caption': jQuery(this._caption).val() ,
		  			'ativo': jQuery(this._ativo).val() ,
		  			'action': jQuery(this._acao).val(),
		  			'gravar': 1,
		  			'insert_event': 1
		  	},
		  	complete:function(){
		  		location.href="?page=listar-timeline";
		  	}
		});
	};

}






