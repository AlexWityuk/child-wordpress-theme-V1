( function($) {
    $(".section-nav-icons .mbmenu-block").on("click", function (e) {
        $(".drop-menu").toggleClass("active");
        e.stopPropagation();
    });

    $(".letters-rule-system .tnnt").on("click", function (e){
    	$(this).toggleClass("active");
    	var post_type = $(this).attr("post-type");
    	//console.log(post_type);
    	jQuery('.sctn .' + post_type).each(function(){
    		$(this).toggleClass("hidden");
    	});
    });
    $(".letters-rule-system .abc i.btn span").on("click", function (e){
        $(this).toggleClass("active");
    	var section = $(this).attr("section");
    	var post_type = $(this).attr("post-type");
        $('#'+ section).toggleClass("active");
    	//console.log(section + ' ' + post_type);
        /*jQuery('.sctn').each(function(){
            $(this).addClass("hidden");
            if ($(this).hasClass( "active" )) {
                $(this).removeClass("hidden");
            };
        });*/
        jQuery('.filterDiv').each(function(){
            $(this).addClass("hidden");
            if ($(this).hasClass( post_type ) && $(this).parent().hasClass("active")) {
                 $(this).removeClass("hidden");
            };
        });
        /*jQuery('#'+ section + ' .filterDiv').each(function(){
            $(this).addClass("hidden");
            if ($(this).hasClass( post_type ) ) {
                 $(this).removeClass("hidden");
            };
        });*/
        /*var k = 0;
        $('.cmp-list-wrap .active').each(function(){
            k++;
        });
        if (k == 0) {
            $('.sctn').each(function(){
                $(this).removeClass("hidden");
            });
        }*/
    });
} )(jQuery);