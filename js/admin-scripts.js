( function($) {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 var directory =  $('select#guida-items-directory').val();
    $( "select#guida-items-directory" ).autocomplete({
      source: function( request, response ) {
        directory =  $('select#guida-items-directory').val();
        data = {
            'action': 'my_admin_action',
            'directory' : directory,
        };
        jQuery.post( admin_toplegal_ajax.url, data, function( res ) {
          console.log(res);
          //response( res );
          //$('#log').html(res);
        });
      //minLength: 2
      /*,
      select: function( event, ui ) {
        log( "Selected: " + ui.item.value + " aka " + ui.item.id );*/
      }
    });

    $('.rcbMoreResults').on('click', function(){
        $loader = $(this).parents('.ui-widget').find('.loader');
        $loader.show();
        var post_type = '';
        if ($(this).find('a').attr('id') == 'studio') post_type = 'studio';
        else if ($(this).find('a').attr('id') == 'professionista') post_type = 'professionista';
        console.log('moreResults!!!' + post_type +'****');
        var $t = $(this);
        data = {
            'action': 'moreResults_action',
            'search-guida-item-type' : post_type
        };
        jQuery.post( admin_toplegal_ajax.url, data, function( res ) {
            console.log(res);
            //$('.cmp-list-wrap').html(res);
            $loader.hide();
            $('div#log-'+post_type+'>div.items-st-prof').html('');
            var res = res.split('**&**');
            $('div#log-'+post_type+'>div.items-st-prof').html(res[0]);
            //$('#ctl00_contenutoControlli_boxDettaglioCentroStudi1_gvProf_ctl00_ctl07_listStudiProf_MoreResultsBox span').html(res[1]);
            $t.children('span').html(res[1]);
        });
    });

    $(document).on("click", '.items-st-prof ul.rcbList li', function(e){
      //console.log($(this).html());
      var post_type = $(this).attr('post-type');
      $('#guida-item-external-id-'+post_type).val($(this).html());
      bind_external_id = $(this).attr('id');
      $('#guida-item-external-id-'+post_type+'-hidden').val(bind_external_id);
      $(this).parents('#log-'+post_type).removeClass('active');
    });

    $('#studio-show-result-arrow').on( "click", function(e){
      $('#log-studio').toggleClass("active");
    });
    $('#professionista-show-result-arrow').on( "click", function(e){
      $('#log-professionista').toggleClass("active");
    });
    //$( "input.search-extrnal-items" ).on("change paste keyup", function() {
    $( "input.search-extrnal-items" ).keyup(function() {
        console.log('***input change***!!!');
        var $log = $(this).parents('.ui-widget').find('.log');
        //$log.find('.loader').show();
        if ( !$log.hasClass("active")) {
            $log.addClass("active")
        }
        var search_word = $(this).val();
        var post_type  = $(this).attr('post-type');
        console.log(post_type);
        data = {
            'action': 'search_admin_external_item_action',
            'search_admin_external_word' : search_word,
            'type' : post_type
        };
        setTimeout( function(){
          $log.find('.loader').show();
        jQuery.post( admin_toplegal_ajax.url, data, function( res ) {
            //console.log(res);
            $log.find('.loader').hide();
            $('div#log-'+post_type+'>div.items-st-prof').html('');
            var res = res.split('**&**');
            $('div#log-'+post_type+'>div.items-st-prof').html(res[0]);
            $log.find('.rcbMoreResults').children('span').html(res[1]);
        }); }, 1000 );
    });
    
    if ($("select#guida-items-directory" ).val() == 'professionista') {
        $('#ui-professionista').addClass('active');
    };

    $( "select#guida-items-directory" ).on('change', function() {
        //console.log( "Handler for .change() called." );
        $('#ui-professionista').toggleClass("active");
    });

} )(jQuery);