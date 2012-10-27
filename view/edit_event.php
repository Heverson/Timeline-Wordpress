<link rel="stylesheet" href="../wp-content/plugins/timeline/css/timeline.css" />
<link rel="stylesheet" href="../wp-content/plugins/timeline/css/ui-lightness/jquery-ui-1.8.23.custom.css" />
<div class="wrap">
	<h2>{title_page} <a href="?page=listar-timeline&action=list_eventos&id_timeline={id_timeline}" class="add-new-h2" title="Voltar para lista de evento"> Voltar para lisa de Evento </a></h2>
	
	<div> {description_page} </div>

	<div class="line-3"></div>
	
	<div id="f-content_form">
		<form action="" name="create_event" id="create_event">
			<div id="title">
				<span class="title-input">Titulo do Evento:</span>
				<input type="text" name="headline" class="inputtext-largex headline" id="title" value="{headline}">
			</div>
			
			<input type="hidden" class="id_timeline" name="id_timeline" value="{id_timeline}">        
			<div id="dates-form">
				<div class="grid-200">
					<label for="start date"></label>
					<span class="title-input">Data Inicial:</span>
					<input type="text" name="start_date" class="inputtext-smallx f-startdate start_date" placeholder="" value="{startDate}" />
				</div>
				<div class="grid-200">
					<span class="title-input">Data Final:</span>
					<label for="end date"></label>	
					<input type="text" name="end_date"  class="inputtext-smallx f-enddate end_date" placeholder=""  value="{endDate}" />
				</div>
			</div>
			<div class="line"></div>
			<div id="media-event">
				<p>Deseja inserir uma <strong>mídia</strong> nesse evento? <input type="checkbox" id="exibir_media" checked="checked" /></p>
				<div class="grid-300">
					<label for="mídias" class=""></label>
					<span class="title-input">Mídia:</span><br>
					<textarea name="midia" id="midia" cols="40" rows="7" class="midia" placeholder="Coloque o script da sua mídia">{media}</textarea>
				</div>
				<div class="grid-300">
					<div id="box-asset">
						<div id="asset-midia">
							<p>
								<label for="credit"></label>
								<span class="title-input">Créditos: </span>
								<input type="text" name="assets_credit" class="inputtext-small assets_credit"  placeholder="" value="{credito}"/>
							</p>
							<p>
								<label for="caption"></label>
								<span class="title-input">Legenda: </span>
								<input type="text" name="assets_caption"  class="inputtext-small assets_caption"  placeholder="" value="{caption}" />
							</p>
						</div>
					</div>
				</div>	
				<div id="midia-library">
					<table class="widefat" class="grid-300">
						<thead><th>Imagens da sua Bibliotéca</th> </thead> 
						<tbody id="the-list">
							{tdListaImagens}
						</tbody>		
					</table>
				</div>
			</div>
			
			<div class="prettyprint">
				A timeline suporta mídias de (Twitter, Flickr, Google Maps, YouTube, Vimeo, Dailymotion, Wikipedia, SoundCloud e mais tipos de mídia no Futuro.)

				Para ultilizar imagens ja cadastradas na sua Biblioteca.
			</div>
			
			
			<div class="line"></div>
			<div id="text-form">
				<label for="description" class=""></label>
				<span class="title-input">Descrição do evento:</span><br>
				<textarea name="description_text" class="description_text" cols="60" rows="10" placeholder="Coloque o script da sua mídia">{text}</textarea>
				<input type="hidden" name="acao" value="edit_event" />
			</div>	
			<div>
				<input type="hidden" name="id_eventotimeline" class="id_eventotimeline" value="{id_eventotimeline}"/>
				<input type="button" value="Alterar Evento" class="f-btn btn-submit button-primary" />
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery.dataTables.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/DT_bootstrap.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/plugin.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/plugin.event.timeline.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.widefat').dataTable({"bPaginate": true});
		// verifica se a mídia está marcada, e mostra os campos
		if (jQuery('input:checked').length === 1) { jQuery('#media-event .grid-300, #midia-library').show()};

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
	});
	
</script>