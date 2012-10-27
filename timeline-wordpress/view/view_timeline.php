<body>
<div class="wrap">
    <h2>{title_page} <a href="?page=listar-timeline&action=list_timeline" class="add-new-h2" title="Voltar para lista de Timelines"> Voltar para lista de Timelines</a></h2>
    
    <div id="content-timeline">
       Visualizar outra Timeline: {select_input}
    </div>
    <div class="line-3"></div>
    <br>
    <div id="timeline-embed"></div>
</div>    

<script type="text/javascript">
    var timeline_config = {
        lang:   "pt-br",
        source: "{url_path}/wp-admin/admin.php?page=listar-timeline&json-request=1&id_timeline={id_timeline}",
        css: "{url_path}/wp-content/plugins/timeline/js/compiled/css/timeline.css",
        js: "{url_path}/wp-content/plugins/timeline/js/compiled/js/timeline-min.js",
        embed_id : "timeline-embed"    
    }
</script>

</body>
</html>

<script type="text/javascript" src="{url_path}/wp-content/plugins/timeline/js/compiled/js/timeline-embed.js" type="text/javascript"></script>
<link rel="stylesheet" href="{url_path}/wp-content/plugins/timeline/css/timeline.css"/>

