<!-- criar timeline	-->
<link rel="stylesheet" href="../wp-content/plugins/timeline/css/timeline.css" />
<link rel="stylesheet" href="../wp-content/plugins/timeline/css/DT_bootstrap.css" />
<div class="wrap">
  
  <h2>Listagem das Timelines</h2>
  <form action="" method="post" id="form_list">
  	
    <p>Esta página apresenta as ultimas timelines cadastradas no sistema.</p>
    <br>
    <select name="action_form" id="action_form">
  		<option value="0">Ações em Massa</option>
  		<option value="1">Editar</option>
  		<option value="2">Excluir</option>
  	</select>
  	<input type="button" id="doaction" class="button-secondary action" value="Aplicar">

	<table class="widefat">
		<thead>
			<th class="manage-column column-cb check-column">
				<input type="checkbox" name="ID_TIMELINE[]" class="id_registro" />
			</th>
			<th>Titulo</th>
			<th>Shortcode</th>
			<th>Data de Cadastro</th>
			<th>Eventos</th>
			<th>Visualizar</th>
		</thead>
		<tbody id="the-list">
		{tableTD}
		</tbody>
		<tfoot>
			<th class="manage-column column-cb check-column"><input type="checkbox" name="ID_TIMELINE[]" /></th>
			<th>Titulo</th>
			<th>Shortcode</th>
			<th>Data de Cadastro</th>
			<th>Eventos</th>
			<th>Visualizar</th>
		</tfoot>
	</table>
	
	<p>&nbsp;</p>
  </form>
</div>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery.dataTables.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/libs/DT_bootstrap.js"></script>
<script type="text/javascript" src="../wp-content/plugins/timeline/js/plugin.js"></script>


<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.widefat').dataTable();

		jQuery('#doaction').click(function(){
		
			var action = new ActioninMass(); 
			var form = '#form_list';
			action.id_reg = [];
			action.id_name= "id_timeline";
			// monta o array de id
			jQuery('input:checked').each(function(i){
				action.id_reg[i] = jQuery(this).val();
			});

			// nenhum id foi selecionado
			if(action.id_reg.length < 1){return false}

			// busca a ação selecionada	
			var action_select = jQuery('#action_form option:selected').val();

			// não marcou a ação
			if (action_select == 0) { alert("Escolha a ação a ser aplicada"); return false};
			if (action_select == 1) { 
				if (action.id_reg.length > 1) {
					alert("Escolha apenas 1 Timeline para editar"); return false;
				}
				else{
					action.action_url = "edit_timeline";
					action.actionEdit();
				}
			};
			// se for exclusão
			if (action_select == 2) { 
				action.action_url = "delete_timeline";
				action.actionDelete();
			};
		});
	});
</script>
