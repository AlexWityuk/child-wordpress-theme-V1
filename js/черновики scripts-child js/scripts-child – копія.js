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
    	var section = $(this).attr("section");
    	var post_type = $(this).attr("post-type");
    	//console.log(section + ' ' + post_type);
    	jQuery('#'+ section + ' .' + post_type).each(function(){
    		$(this).toggleClass("hidden");
    	});
    });
} )(jQuery);