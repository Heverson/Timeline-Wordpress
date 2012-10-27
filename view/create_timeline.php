<!-- criar timeline	-->
<link rel="stylesheet" href="../wp-content/plugins/timeline/css/timeline.css" />
<link rel="stylesheet" href="../wp-content/plugins/timeline/css/ui-lightness/jquery-ui-1.8.23.custom.css" />
<div class="wrap">
	<h2>{title_page}</h2>
	<div>
		{description_page}
	</div>
	<div id="f-content_form">
		<form id="form_create" class="grid-600">
			<label for="" class="grid-400 f-labels">
				<span class="grid-200 f-spans"> Titulo da Timeline: </span> 
				<input type="text" class="f-inputs f-headline" name="HEADLINE" />
			</label>
			<label for="">
				<span class="grid-200 f-spans">Data de inicio:</span>
				<input type="text" class="f-inputs f-startdate" name="STARTDATE" />
			</label>
			<input type="hidden" name="STARTDATE" class="f-startdate" value="" />
			<input type="hidden" name="TYPE" class="f-type" value="default" />
			<input type="hidden" name="DATACADASTRO" class="f-datacadastro" value="{datacadastro}" />
			<input type="hidden" name="acao" value="insert_timeline" class="acao" />
			<input type="hidden" name="id_timeline" value="" class="f-id_timeline" />
			<label for="" class="grid-400 f-labels">
				<span class="grid-200 f-spans">Descrição (html/text)</span>
				<textarea name="TEXT" class="f-description" cols="50" rows="10"></textarea>
			</label>
			<input type="button" class="f-btn btn-submit button-primary" value="Gravar"/> 
		</form>	
	</div> 	
</div>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/plugin.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/plugin.timeline.js"></script>