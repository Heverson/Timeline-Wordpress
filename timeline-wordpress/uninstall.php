<?php 

public static function desinstalar(){

	//Remover bases de dados
	$sqlContador = "DROP TABLE `".meuPrimeiroPlugin::$wpdb-&gt;prefix."mpp_post_visitas`";
	$sqlPalavras = "DROP TABLE `".meuPrimeiroPlugin::$wpdb-&gt;prefix."mpp_substituicao`";

	meuPrimeiroPlugin::$wpdb-&gt;query($sqlContador);
	meuPrimeiroPlugin::$wpdb-&gt;query($sqlPalavras);

	//Remover opções
	delete_option("mpp_texto_exonerar");
}



 ?>