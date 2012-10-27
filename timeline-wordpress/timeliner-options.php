<?php 
/*
Plugin Name: Timeline Verite Wordpress
Description: Plugin para criar Timeline no wordpress, usando o modelo estabelecido pela TimelineJS VéritéCo
Version: 0.1
License: GPL
Author: Heverson Damasceno
Author URI: http://www.heversondamasceno.com.br/
*/


class Timeline {

    private static $wpdb;
    private static $info;

    /**
    * @method initializer
    * Inicialização de objetos
    */
    public static function initializer(){
        global $wpdb;
        //Mapear objetos WPDB
        Timeline::$wpdb = $wpdb;
        //Outros mapeamentos
        Timeline::$info['plugin_fpath'] = dirname(__FILE__); 
    }

    /**
     * @method type_post_Timeline
     * Adicionando o menu Timelines no Dashboard
     */
    public function type_post_Timeline() { 
       add_menu_page( 'Timeline Wordpress', 'Timeline', '', 'timeline/view/list_timelines.php', '' , plugins_url('timeline/images/icon.png'), 6 ); 
   }

    /**
     * @method tdd_beans_menu
     * Adicionando a Cadastro das Timelines
     */ 
    public function tdd_beans_menu(){
        
        add_submenu_page( 'timeline/view/list_timelines.php', 'Listar Timeline', 'Listar Timeline', 'manage_options', 'listar-timeline', array('Timeline' ,'list_timelines' ));
        add_submenu_page( 'timeline/view/list_timelines.php', 'Adicionar Timeline', 'Adicionar Timeline', 'manage_options', 'create-timeline', array('Timeline' ,'create_timeline' ));


    }    

    /**
    * @method create_tablesDB
    * Cria as tabelas da base de dados
    */
    public static function create_tablesDB(){

       if ( is_null(Timeline::$wpdb) )
            Timeline::initializer();

        //tabela da Timeline
        $sqlTimeline = "CREATE  TABLE IF NOT EXISTS 
                            `".Timeline::$wpdb->prefix."timeline` (
                                `ID_TIMELINE` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                `headline` VARCHAR(100) NOT NULL ,
                                `startDate` INT NULL ,
                                `text` VARCHAR(255) NOT NULL ,
                                `type` VARCHAR(20) NULL ,
                                `DATACADASTRO` INT NULL ,
                                `ATIVO` INT NULL )";
        //tabela dos Eventos
        $sqlEventos = "CREATE  TABLE IF NOT EXISTS 
                            `".Timeline::$wpdb->prefix."timeline_event` (
                            `ID_EVENTOTIMELINE` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            `ID_TIMELINE` VARCHAR(255) NULL ,
                            `headline` VARCHAR(100) NOT NULL ,
                            `startDate` INT NOT NULL ,
                            `endDate` INT NOT NULL,
                            `text` VARCHAR(255) NOT NULL ,
                            `media` VARCHAR(255) NULL,
                            `credit` VARCHAR(255) NULL,
                            `caption` VARCHAR(255) NULL,
                            `DATACADASTRO` INT NOT NULL,
                            `AUTOR` VARCHAR(100) NOT NULL,
                            `ATIVO` INT NOT NULL)";

        Timeline::$wpdb->query($sqlTimeline);
        Timeline::$wpdb->query($sqlEventos);
    }

    /**
     * @method dropTables
     * Deleta as tabelas do plugin na base de dados
     */
    public static function dropTables(){

        //Remover bases de dados
        $sqlTimeline = "DROP TABLE `".Timeline::$wpdb->prefix."timeline`";
        $sqlEventos = "DROP TABLE `".Timeline::$wpdb->prefix."timeline_event`";
        // execultando a query
        Timeline::$wpdb->query($sqlTimeline);
        Timeline::$wpdb->query($sqlEventos);
    }

/*************************************************************************************************
* CRUD  - Timeline 
*       - Eventos 
**************************************************************************************************/

    /**
    * @method list_timelines
    * Faz a listagem das timeline cadastradas no sistema.
    */
    public function list_timelines(){

        // recupera os resultados da consulta                    
        $result = Timeline::getTimeline();                    

        // inicia a variável do html 
        $template_tr_td = "";
        
        // preenche a variável montando o html com os valores dentro
        foreach ($result as $key => $value) {
            $template_tr_td .= "<tr>";
            $template_tr_td .= "<td id='cb' class='check-column'><input type='checkbox' name='ID_TIMELINE[]' value='".$value->ID_TIMELINE."' /></td>";
            $template_tr_td .= "<td>".$value->headline."</td>";
            $template_tr_td .= "<td><strong>[timeline id=".$value->ID_TIMELINE."]</strong></td>";
            $template_tr_td .= "<td>".Timeline::intToData($value->DATACADASTRO)."</td>";
            $template_tr_td .= "<td> <a href='?page=listar-timeline&action=list_eventos&id_timeline=".$value->ID_TIMELINE."' class='f-btn btn-submit button-primary'>Listar eventos</a> </td>";
            $template_tr_td .= "<td> <a href='?page=listar-timeline&action=view_timeline&id_timeline=".$value->ID_TIMELINE."' class='f-btn btn-submit button-primary'>Visualizar timeline</a> </td>";
            $template_tr_td .= "</tr>";
        }
        
        // monta o array de substituição
        $templateVars = array('{tableTD}' => $template_tr_td);

        // cria o objeto de leitura de arquivo
        $pglistagem = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/list_timelines.php");
        // faz a leitura do arquivo
        
        $pglistagem_php = $pglistagem->read(filesize(Timeline::$info['plugin_fpath']."/view/list_timelines.php"));
        
        // substitui os valores
        $html_page = strtr($pglistagem_php, $templateVars);
        
        // Verifica a ação referente a timeline da lista, e execulta sua ação
        if (!empty($_GET['action'])){

            switch ($_GET['action']){
                
                // visualizar timeline    
                case 'view_timeline':
                   Timeline::view_timeline($_GET['id_timeline']);
                    exit;
                break;
                // timeline deletada
                case 'delete_timeline':
                    if (!empty($_GET['id'])){
                        Timeline::delete_timeline($_GET['id']);
                        exit;
                    }
                    break;
                // timeline editada
                case 'edit_timeline':
                    if (!empty($_GET['id_timeline'])){
                        (int)$_GET['id_timeline'];  
                        Timeline::edit_timeline($_GET['id_timeline']);
                        exit;
                    }
                    break;
                // cadastrar evento
                case 'create_event':
                    if (!empty($_GET['id_timeline'])){
                      (int)$_GET['id_timeline'];  
                      Timeline::create_event($_GET['id_timeline']);
                      exit;
                    }
                    break;
                // editar evento    
                case 'edit_event':
                    if (!empty($_GET['id_eventotimeline'])){
                      (int)$_GET['id_eventotimeline'];  
                      Timeline::edit_event($_GET['id_eventotimeline']);
                      exit;
                    }
                    break;
                // listar evento
                case 'list_eventos':
                    if (!empty($_GET['id_timeline'])){
                      (int)$_GET['id_timeline'];  
                      Timeline::list_eventos($_GET['id_timeline']);
                      exit;
                    }
                    break;
                // evento deletado
                case 'delete_event':
                    if (!empty($_GET['id'])){
                        Timeline::delete_event($_GET['id']);
                        exit;
                    }
                    break;
                // recuperar timeline
                case 'get_timeline':
                    $result =  Timeline::getTimeline();
                    echo json_encode($result);
                    exit();
                    break;    
            }
        }
        // imprime a página
        echo $html_page;
    }

    /**
     * @method create_timeline
     * Cadastro inicial das Timelines.
     */
    public function create_timeline() {
        // Inserir os registros da Timeline
        if(!empty( $_GET['insert_timeline']) ){
            
            // monta a SQL para inserção dos dados
            $sqlTimeline = "INSERT INTO `".Timeline::$wpdb->prefix."timeline`
                            (headline, startDate, text, type, DATACADASTRO, ATIVO)
                            VALUES( '".$_GET['HEADLINE']."'  , 
                                    '".$_GET['STARTDATE']."', 
                                    '".$_GET['TEXT']."', 
                                    '".$_GET['TYPE']."', 
                                    '".$_GET['DATACADASTRO']."',
                                     '1' )"; 

            // executa o insert dos registros
            Timeline::$wpdb->query($sqlTimeline);
            exit();
        } 
        else{
            // cria o objeto de leitura de arquivo
            $pgcadastro = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/create_timeline.php");
            // faz a leitura do arquivo
            $pgcadastro_html_page = $pgcadastro->read(filesize(Timeline::$info['plugin_fpath']."/view/create_timeline.php"));
            // monta o array de variaveis
            $templateVars= array('{title_page}' =>  'Cadastrar Timeline',
                                 '{description_page}' => 'Faça o cadastro inicial da Timeline.',
                                 '{datacadastro}' => date('Ymd'));

            // subistitui as palavras
            $html_page = strtr($pgcadastro_html_page, $templateVars);
            echo $html_page;
        }
    }

    /**
    * @method edit_timeline
    * Edição da timeline
    * @param $id_timeline
    */
    public static function edit_timeline($id_timeline){
       
        if(empty($_GET["insert_timeline"])){
            $timeline = Timeline::getTimeline($id_timeline);
            // cria o objeto de leitura de arquivo
            $pgeditar = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/edit_timeline.php");
            // faz a leitura do arquivo
            $pgeditar_html_page = $pgeditar->read(filesize(Timeline::$info['plugin_fpath']."/view/edit_timeline.php"));
            // monta o array de variaveis
            $templateVars= array('{title_page}' =>  'Alterar Timeline',
                                 '{description_page}' => 'Faça a alteração da Timeline.',
                                 '{datacadastro}' => date('Ymd'),
                                 '{headline}'=> $timeline[0]->headline,
                                 '{startDate}'=> $timeline[0]->startDate,
                                 '{text}'=> $timeline[0]->text,
                                 '{datacadastro}'=> $timeline[0]->DATACADASTRO,
                                 '{descricao}'=> $timeline[0]->text,
                                 '{id_timeline}'=> $timeline[0]->ID_TIMELINE
                                 );

            // subistitui as palavras
            $html_page = strtr($pgeditar_html_page, $templateVars);
            echo $html_page;
        }
        else{
            // monta a SQL para inserção dos dados
            $sqlTimeline = "UPDATE `".Timeline::$wpdb->prefix."timeline`
                            set headline = '".$_GET['HEADLINE']."', 
                            startDate = '".$_GET['STARTDATE']."', 
                            text = '".$_GET['TEXT']."',
                            type = '".$_GET['TYPE']."', 
                            DATACADASTRO = '".$_GET['DATACADASTRO']."', 
                            ATIVO = 1 WHERE ID_TIMELINE = ".$_GET['id_timeline']." ;" ; 
            Timeline::$wpdb->query($sqlTimeline);
        }
    }

    /**
    * @method delete_timeline
    * Exclusão da Timeline
    * Considera a exclusão de todos eventos dessa Timeline.
    * @param $id_timeline
    */
    public function delete_timeline($id_timeline)
    {
        // deleta a timeline
        $sqlTimeline = "DELETE FROM wp_timeline WHERE ID_TIMELINE IN (".implode(", ", $id_timeline).")";
        Timeline::$wpdb->query($sqlTimeline);
        // deleta os eventos da timeline    
        $sqlEventos = "DELETE FROM `".Timeline::$wpdb->prefix."timeline_event` 
                                WHERE ID_TIMELINE IN (".implode(", ", $id_timeline).")";
        Timeline::$wpdb->query($sqlEventos);                                    
    }

    /**
    * @method json_timeline
    * recupera a timeline, e imprime o Array no formato JSON
    * para ser consumido pelo JavaScript.
    * Obs: a chamada para essa função está na linha 587.
    */
    public function json_timeline(){
        
        // recupera o id do Ajax
        $id_timeline = $_GET['id_timeline'];
        $timeline = Timeline::getTimeline($id_timeline);

        // monta a linha do tempo
        $json['timeline'] = array();
        $json['timeline']['headline'] = $timeline[0]->headline;
        $json['timeline']['type'] = 'default';
        $json['timeline']['startDate'] = $timeline[0]->startDate;
        $json['timeline']['text'] = $timeline[0]->text;
        
        // recupera os eventos da Timeline
        $eventos = Timeline::getEventos('', $id_timeline);

        // se existir eventos
        if (!empty($eventos)) {
            $json['timeline']['date'] =  array();
            $i = 0;
            // monta array de eventos
            foreach ($eventos as $key => $value){
                $json['timeline']['date'][$i]['startDate'] = $value->startDate. '0:00:00';
                $json['timeline']['date'][$i]['endDate'] = $value->endDate. '0:00:00';
                $json['timeline']['date'][$i]['headline'] = $value->headline;
                $json['timeline']['date'][$i]['text'] = $value->text;
                if (!empty($value->media)) {
                    $json['timeline']['date'][$i]['asset'] =  array();
                    $json['timeline']['date'][$i]['asset']['media'] = $value->media;
                    $json['timeline']['date'][$i]['asset']['credit'] = $value->credit;
                    $json['timeline']['date'][$i]['asset']['caption'] = $value->caption;
                }
                $i++;
            }
        }
        // imprime JSON
        header('ContentType: application/json');       
        echo  json_encode($json);
        exit();
    }

    /*
    * @method view_timeline
    * Área de visualização da Timeline
    * @param id_timeline
    */
    public static function view_timeline($id_timeline){

        // cria o objeto de leitura de arquivo
        $pgcadastro = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/view_timeline.php");
        
        // faz a leitura do arquivo
        $pgcadastro_html_page = $pgcadastro->read(filesize(Timeline::$info['plugin_fpath']."/view/view_timeline.php"));
        $timeline = Timeline::getTimeline();
        
        if(!empty($timeline)){
            $inputSelect = "<select name='id_timeline'>";
            // monta os options
            foreach ($timeline as $key => $value)
                $inputSelect .= "<option value='".$value->ID_TIMELINE."'>".$value->headline."</option>";
            
            $inputSelect .= "</select>";
        }
        
        // monta o array de variaveis
        $templateVars= array('{title_page}' =>  'Timeline',
                            '{description_page}' => '',
                            '{select_input}' => (!empty($timeline)) ? $inputSelect : '',                        
                            '{url_path}' => get_bloginfo('url'),
                            '{id_timeline}' => $id_timeline);
        
        // substitui as palavras
        $html_page = strtr($pgcadastro_html_page, $templateVars);
        echo $html_page;
    }

    /**
     * @method creat_event
     * Cadastra os eventos referente a timeline 
     * @param id_timeline
     */
    public static function create_event($id_timeline){

        // Inserir os registros do Evento
        if(!empty( $_GET['insert_event']) ){
            // monta a SQL para inserção dos dados
            $sqlEvento = "INSERT INTO `".Timeline::$wpdb->prefix."timeline_event`
                            (`ID_EVENTOTIMELINE`, `ID_TIMELINE`, `headline`, `startDate`, `endDate`, `text`, `media`, `credit`, `caption`, `DATACADASTRO`, `AUTOR`, `ATIVO`) 
                            VALUES ( NULL, '".$_GET['id_timeline']."', '".$_GET['headline']."' , ";
            $sqlEvento .=  " '".$_GET['startDate']."' ,";                                               
            $sqlEvento .=  !empty($_GET['endDate']) ? "'".$_GET['endDate']."', " : " NULL, ";
            $sqlEvento .=  !empty($_GET['text']) ? "'".$_GET['text']."'," : " NULL, ";                                               
            $sqlEvento .=  !empty($_GET['media'])   ? "'".$_GET['media']."', "   : " NULL, ";
            $sqlEvento .=  !empty($_GET['credit'])  ? "'".$_GET['credit']."', "  : " NULL, ";
            $sqlEvento .=  !empty($_GET['caption']) ? "'".$_GET['caption']."', " : " NULL, ";
            $sqlEvento .= "'".date('Ymd')."', ";
            $sqlEvento .= "'".the_author()."', ";
            $sqlEvento .=  "'1');";

            // executa o insert dos registros
            Timeline::$wpdb->query($sqlEvento);
            
            // caso ocorra tudo certo
            echo json_encode(array('result' => 'Evento inserido com sucesso, comece a criar os eventos!' ));
        } 
        else{
            
            // recupera as imagens armazenadas na Biblioteca de Mídia
            $args = array('post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_mime_type' => 'image', 'post_parent' => null); 
            $attachments = get_posts($args);
            
            // monta a tabela que irá listar as imagens
            $list_images = ""; 

            foreach ($attachments as $key => $value)
                $list_images .= "<tr><td><span class='addimg-media' data-mediaimg='".$value->guid."'> ".$value->post_title." </span></td></tr>";        

            // cria o objeto de leitura de arquivo
            $pgcadastro = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/create_event.php");
            // faz a leitura do arquivo
            $pgcadastr_html_page = $pgcadastro->read(filesize(Timeline::$info['plugin_fpath']."/view/create_event.php"));
            // monta o array de variaveis

            $templateVars= array('{title_page}' =>  'Cadastrar Eventos para a Timeline',
                                '{description_page}' => 'Preencha os dados da Timeline',
                                '{id_timeline}' => $id_timeline,
                                '{tdListaImagens}' => $list_images);
            // subistitui as palavras
            $html_page = strtr($pgcadastr_html_page, $templateVars);
            echo $html_page;
        }
    }

    /**
    * @method list_event
    * Lista todos os eventos da timeline
    * @param int id_timeline
    */
    public static function list_eventos($id_timeline){
        
        // recupera a timeline
        $result = Timeline::getEventos('',$id_timeline);
       
       // monta as linhas da tabela
       $template_tr_td = " ";
        foreach ($result as $key => $value) {
            $template_tr_td .= "<tr>";
            $template_tr_td .= "<td id='cb' class='check-column'><input type='checkbox' name='ID_EVENTOTIMELINE[]' value='".$value->ID_EVENTOTIMELINE."' /></td>";
            $template_tr_td .= "<td>".$value->headline."</td>";
            $template_tr_td .= "<td>".Timeline::intToData($value->startDate)."</td>";
            $template_tr_td .= "<td>".Timeline::intToData($value->endDate)."</td>";
            $template_tr_td .= "<td> <a href='?page=listar-timeline&action=edit_event&id_eventotimeline=".$value->ID_EVENTOTIMELINE."' class='f-btn btn-submit button-primary'>Editar eventos</a> </td>";
            $template_tr_td .= "</tr>";
        }

        // cria o objeto de leitura de arquivo
        $pgcadastro = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/list_eventos.php");
        // faz a leitura do arquivo
        $pgcadastr_html_page = $pgcadastro->read(filesize(Timeline::$info['plugin_fpath']."/view/list_eventos.php"));
        // monta o array de variaveis
        $templateVars= array('{title_page}' =>  'Listar Eventos para a Timeline',
                            '{description_page}' => '',
                            '{id_timeline}' => $id_timeline,
                            '{tableTD}' => $template_tr_td);
        
        // substitui as palavras
        $html_page = strtr($pgcadastr_html_page, $templateVars);
        echo $html_page;
    }

    /**
    * @method edit_event
    * Edição dos eventos da Timeline
    * @param id_eventotimeline
    */
    public static function edit_event($id_eventotimeline){
        if (!empty($_GET['gravar'])) {
            
            // monta a SQL para inserção dos dados
            $sqlEvento = "UPDATE `".Timeline::$wpdb->prefix."timeline_event` SET ID_TIMELINE = '".$_GET['ID_TIMELINE']."', headline = '".$_GET['headline']."' , "; 

            $sqlEvento .=  " startDate = '".$_GET['startDate']."' ,";
            $sqlEvento .=  !empty($_GET['endDate']) ? " endDate = '".$_GET['endDate']."', "  : "";
            $sqlEvento .=  !empty($_GET['text'])    ? " text = '".$_GET['text']."',"         : "";
            $sqlEvento .=  !empty($_GET['media'])   ? " media = '".$_GET['media']."',"       : "";
            $sqlEvento .=  !empty($_GET['credit'])  ? " credit = '".$_GET['credit']."',"     : "";
            $sqlEvento .=  !empty($_GET['caption']) ? " caption = '".$_GET['caption']."', "  : "";
            
            $sqlEvento .= " DATACADASTRO = '".date('Ymd')."', ";
            $sqlEvento .= " AUTOR = '".the_author()."', ";
            $sqlEvento .= " ATIVO = '1'";
            $sqlEvento .= " WHERE ID_EVENTOTIMELINE = '".$_GET['ID_EVENTOTIMELINE']."'";
    
            // executa o insert dos registros
            Timeline::$wpdb->query($sqlEvento);
            return true;
        } 
        
         // recupera as imagens armazenadas na Biblioteca de Mídia
        $args = array('post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_mime_type' => 'image', 'post_parent' => null); 
        $attachments = get_posts($args);
        
        // monta a tabela que irá listar as imagens
        $list_images = ""; 

        foreach ($attachments as $key => $value)
            $list_images .= "<tr><td><span class='addimg-media' data-mediaimg='".$value->guid."'> ".$value->post_title." </span></td></tr>";  

        $result =  Timeline::getEventos($id_eventotimeline);

        // cria o objeto de leitura de arquivo
        $pgcadastro = new POMO_FileReader(Timeline::$info['plugin_fpath']."/view/edit_event.php");
        // faz a leitura do arquivo
        $pgcadastr_html_page = $pgcadastro->read(filesize(Timeline::$info['plugin_fpath']."/view/edit_event.php"));
        // monta o array de variaveis
        $templateVars= array('{title_page}' =>  'Editar Evento para a Timeline',
                            '{description_page}' => '',
                            '{id_timeline}' => $result[0]->ID_TIMELINE,
                            '{id_eventotimeline}' => $result[0]->ID_EVENTOTIMELINE,
                            '{headline}'    => $result[0]->headline,
                            '{startDate}'   => Timeline::intToData($result[0]->startDate),
                            '{endDate}'     => Timeline::intToData($result[0]->endDate),
                            '{text}'        => $result[0]->text,
                            '{media}'       => $result[0]->media,
                            '{credito}'     => $result[0]->credit,
                            '{caption}'     => $result[0]->caption,
                            '{tdListaImagens}' => $list_images);
        
        // substitui as palavras
        $html_page = strtr($pgcadastr_html_page, $templateVars);
        echo $html_page;
    }

    /**
    * @method delete_event
    * Deleta o evento passado como parâmetro
    */
    public static function delete_event($id_evento){
        $sqlEvento = "DELETE FROM wp_timeline_event WHERE ID_EVENTOTIMELINE IN (".implode(", ", $id_evento).")";
        Timeline::$wpdb->query($sqlEvento);    
    }

    /**
    * @method getEventos
    * Recupera os eventos da Timeline
    */
    public static function getEventos($id_evento, $id_timeline=""){

        // recupera os eventos da timeline
        $sqlEvento = "SELECT * FROM wp_timeline_event "; 
        $sqlEvento .= "WHERE ";
        $sqlEvento .= !empty($id_evento) ? "ID_EVENTOTIMELINE = ".$id_evento : " ";
        $sqlEvento .= !empty($id_timeline) ? "ID_TIMELINE = ".$id_timeline : " ";
        $sqlEvento .= " ORDER BY ID_EVENTOTIMELINE DESC";
        $eventos = Timeline::$wpdb->get_results($sqlEvento);
        return $eventos;
    }

    /**
    * @method getTimeline
    * Recupera a Timeline
    */
    public static function getTimeline($id_timeline=""){
        $sqlTimeline = "SELECT * FROM wp_timeline";

        if(!empty($id_timeline))
            $sqlTimeline .= " WHERE ID_TIMELINE = ".$id_timeline; 

        $sqlTimeline .= " ORDER BY DATACADASTRO ASC";
        $timeline = Timeline::$wpdb->get_results($sqlTimeline);
           
        return $timeline;
    }

    /**
    * @method intToData
    * Transforma de inteiro para data
    */
    public static function intToData($data) {
        preg_match("/^([0-9]{4})+([0-9]{2})+([0-9]{2})$/i ", $data, $matche);
        return $matche[3].'/'.$matche[2].'/'.$matche[1];
    }


 /*=================================================================================
 TinyMCE button Timeline
 =================================================================================*/   

    public static function register_button( $buttons ){
        array_push( $buttons, "|", "timeline" );
        return $buttons;
    }

    public static function add_plugin($plugin_array){
       $plugin_array['timeline'] = get_bloginfo('url') . '/wp-content/plugins/timeline/js/button_mce_timeline.js';
       return $plugin_array;
    }

    public static function my_mce_button(){   
        
        if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') )
            return;
        
        if ( get_user_option('rich_editing') == 'true' ) {
            add_filter( 'mce_external_plugins',  array('Timeline' ,'add_plugin'));
            add_filter( 'mce_buttons',  array('Timeline' ,'register_button'));
        }
    }
}

// adiciona a uma variavel o Path do Plugin
$timelinePluginFile = substr(strrchr(dirname(__FILE__),DIRECTORY_SEPARATOR),1).DIRECTORY_SEPARATOR.basename(__FILE__);
// função de instalação
register_activation_hook($timelinePluginFile, array('Timeline' , 'create_tablesDB') );
// destivar 
register_deactivation_hook( $timelinePluginFile, array('Timeline' , 'dropTables' ));

// inicia o plugin    
add_action('init', array('Timeline' , 'initializer'));

// adiciona o botão no Editor TinyMCE <== The Future implamentation ==>
//add_action('init', array('Timeline' ,'my_mce_button'));

// inicia a inclusão da timeline no Dashboard do Wordpress
add_action('admin_menu', array('Timeline' , 'type_post_Timeline'));
// adiciona o submenu
add_action('admin_menu', array('Timeline' , 'tdd_beans_menu' ));
//add_action('wp_head', array('Timeline' ,'view_timeline'));
// Verifica a requisição do JSON da TIMELINE
if(!empty($_GET['json-request']))
    add_action('init', array('Timeline', 'json_timeline'));

// shortcode [timeline]
function timeline($atts, $content = null)
{
    extract(shortcode_atts(array('id' => ''),$atts ) );

    echo '<div id="timeline-embed"></div>';
    echo '<script type="text/javascript">';
    echo 'var timeline_config = {';
    echo '  lang:   "pt-br",';
    echo '  width: "700",';
    echo '  source: "'.get_bloginfo("url").'/wp-admin/admin.php?page=listar-timeline&json-request=1&id_timeline='.$id.'",';
    echo '  css: "'.get_bloginfo("url").'/wp-content/plugins/timeline/js/compiled/css/timeline.css",';
    echo '  js: "'.get_bloginfo("url").'/wp-content/plugins/timeline/js/compiled/js/timeline-min.js",';
    echo '  embed_id : "timeline-embed"    ';
    echo '    }';
    echo '</script>';

    echo '<script type="text/javascript" src="'.get_bloginfo("url").'/wp-content/plugins/timeline/js/compiled/js/timeline-embed.js" type="text/javascript"></script>';
    echo '<link rel="stylesheet" href="'.get_bloginfo("url").'/wp-content/plugins/timeline/css/timeline.css"/>';
}
// registrando o shortcode
add_shortcode( 'timeline', 'timeline' );
?>