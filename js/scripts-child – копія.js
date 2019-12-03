( function($) {

    //Scrolling
    var rightcol = $("#external-links");

    $(document).scroll(function(e) {
        //alert($("section.content .container").height());
        if($(this).scrollTop() > $("section.content .container").height() + 400) {

            rightcol.css({"position" : "fixed", "top" : "10px"});
            rightcol.addClass("col-md-3");
        } else {
            rightcol.css("position", "static");
             rightcol.removeClass("col-md-3");
        }
    });

    $(".section-nav-icons .mbmenu-block").on("click", function (e) {
        $(".drop-menu").toggleClass("active");
        e.stopPropagation();
    });

    $(window).on("click", function (e) {
        if ( $(".drop-menu").hasClass('active') ) {
            $(".drop-menu").toggleClass("active");
        }
        e.stopPropagation();
    });


    /*function hideLoader() {
        $('#directorystudi-rightcol .loader').hide();
    }

    $(window).ready(hideLoader);*/

    $( ".content ul.newsCorrelateList li a.fancybox" ).live( "click", function(event) {
        event.preventDefault();
        $(this).fancybox({
          helpers: {
                title : {
                    type : 'float'
                },
                overlay: {
                    locked: false
                }
          }
      });
    });

    // Ajax
    $(document).on("click", ".filterDiv a" ,function(event) {
        event.preventDefault();
        $('#directorystudi-rightcol .content').hide();
        $('#directorystudi-rightcol .loader').show();
        var item_id = $(this).attr('id');
        //console.log(item_id);
        data = {
            'action': 'my_action',
            'itemid' : item_id,
        };
        jQuery.post( toplegal_ajax.url, data, function( res ) {
            $('#directorystudi-rightcol .loader').hide();
            $('#directorystudi-rightcol .content').show();
            $('#directorystudi-rightcol .content').html(res);
            $( ".content ul.newsCorrelateList li a.fancybox" ).click();
        });
    });

    $(".letters-rule-system .tnnt").on("click", function (e){
        var section = $('.letters-rule-system .abc i.btn span.active').attr("section");
        $('.letters-rule-system .abc i.btn span.active').removeClass('active');
        $(".letters-rule-system .tnnt.active").toggleClass("active");
    	$(this).toggleClass("active");

    	var post_type = $(this).attr("post-type");
    	//console.log(post_type, section,'*****');
        //$('.sctn.active').removeClass("active");
        $('.sctn.hidden').removeClass("hidden");
        $('.sctn').addClass("active");
        //$('#'+ section).toggleClass("active");
        $('.filterDiv.active').removeClass('active').addClass('hidden');
        //$('#'+ section + ' .' + post_type).toggleClass("active").toggleClass("hidden");
        $('.' + post_type).toggleClass("active").toggleClass("hidden");
    });
    var arr = { A: [], B: [], C: [], D: [], E: [], F: [], G: [],
                H: [], I: [], J: [], K: [], L: [], M: [], N: [], 
                O: [], P: [], Q: [], R: [], S: [], T: [], U: [], 
                V: [], W: [], X: [], Y: [], Z: []}; // the array
    //console.log(arr);
    $(".letters-rule-system .abc i.btn span").on("click", function (e){
        //var a = 0;
        $('.letters-rule-system .abc i.btn span.active').removeClass("active");
        $(this).toggleClass("active");
        var section = $(this).attr("section");
        //var post_type = $(this).attr("post-type");
        var post_type = $('.letters-rule-system .tnnt.btn.active').attr("post-type");
        //tnntconsole.log(section, post_type, '***$$$***');
        //console.log(post_type);
        $('.sctn.active').removeClass("active").addClass('hidden');
        $('#'+ section).toggleClass("active").toggleClass("hidden");
        $('.filterDiv.active').removeClass('active').addClass('hidden');
        $('#'+ section + ' .' + post_type).toggleClass("active").toggleClass("hidden");
    });
} )(jQuery);