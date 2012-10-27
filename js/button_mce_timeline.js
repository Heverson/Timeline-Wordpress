(function() {

   function montaBoxTimeline(){
      getTimelines();
   }
   function createListTimeline(){
      //console.log(result);
   }

   function getTimelines(){

      jQuery.ajax({
         url: 'admin.php',
         type: 'GET',
         dataType: 'json',
         data: {page: 'listar-timeline', action: 'get_timeline'},
         complete: function(xhr, textStatus) {
            //called when complete
            //createListTimeline(xhr);
         },
         success: function(data, textStatus, xhr) {
         //called when successful
            createListTimeline(data);
         },
         error: function(xhr, textStatus, errorThrown) {
         //called when there is an error
         }
      });

   }

   // Actions do plugin da Timeline   
   tinymce.create('tinymce.plugins.timeline', {
      init : function(ed, url) {
         ed.addButton('timeline', {
            title : 'Timeline',
            image : url+'/../images/icon.png',
            onclick : function() {
               
               montaBoxTimeline();

               // monta a lista no box
                           
               // busca as timelines   
              
               
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Timeline Wordpress",
            author : 'Heverson Damasceno',
            authorurl : 'http://www.heversondamasceno.com.br',
            infourl : 'http://wp.smashingmagazine.com',
            version : "0.1"
         };
      }
   });
   tinymce.PluginManager.add('timeline', tinymce.plugins.timeline);

})();