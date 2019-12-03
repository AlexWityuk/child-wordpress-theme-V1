<?php
/**
* Here is the expanded version of the menu that need to be included 
* in all the pages that regards Guide Toplegal.
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package tecnavia
*/
?>
<div class="guida-drop-menu drop-menu">
	<div class="hamburger-col col-sm-3 col-md-3">
		<div class="guida-hamburger-menu-title">
			<h5>Analisi</h5>
			<p class="triangle-down"></p>
		</div>
		<p class="aree-giuridiche">Aree giuridiche</p>
        <?php
            $arg = array(
                'post_type'        => 'guida',
                'post_status'      => 'publish',
                'posts_per_page'   => -1
            );
            $guida_items = new WP_Query( $arg );
            var_dump($guida_items);
            if ($guida_items->have_posts()) :?>
            <ul class="hamburger-nav">
            	<li>
		            <ul role="menu" class="dropdown-menu">
		            	<?php 
		            	while ( $guida_items->have_posts() ): $guida_items->the_post(); 
		            		$post = get_post(get_the_ID()); 
							$post_slug = $post->post_name; //echo $post_slug;
		            	    /*---------------------------------------------------------------------------------------------*/
						    $settore_ids = array();
						    $arg = array(
						      'post_type'        => 'guida_item',
						      'posts_per_page'   => -1
						    ); 
						    $guida_items = new WP_Query( $arg );
						    while ($guida_items->have_posts()) {
						        $guida_items->the_post();
						        $guida_slug = maybe_unserialize( get_post_meta( get_the_ID(), 'bind-to-guida-slug', true ) );
						        if ($guida_slug == $post_slug) {
						            $this_settore_id = wp_get_post_terms( get_the_ID(), 'settore', array('fields' => 'ids') );
						            $settore_ids[] = $this_settore_id[0];
						        }
						    }
						    if (count($settore_ids) == 0) {
						        $settore_ids[] = 1;
						    }
						    //var_dump($settore_ids);
						    wp_reset_postdata();
						    /*---------------------------------------------------------------------------------------------*/
						    $parent_sectors_name ='';
						    if ( isset( $_GET['type'] ) ) {
						        $parent_sectors_name = $_GET['type'];
						        $parent_sectors = get_term_by('name', $parent_sectors_name, 'settore');
						        $sectors = get_terms( 'settore', array(
						            'parent' => $parent_sectors->term_id,
						            'include' =>$settore_ids
						         ));
						    } else {
						        $sectors = get_terms( 'settore', array(
						            'include' =>$settore_ids
						         ));
						    }
						        $c_terms = array();
							    if( $sectors && ! is_wp_error($sectors) ) {
							       foreach ( $sectors as $term ) {
							           $c_terms[$term->slug] = $term->name;
							       }
							    }
							    $sectors = array_unique($c_terms);
							    $sector = $sectors[0];
						    /*---------------------------------------------------------------------------------------------*/
		            	?>
		            	<li id="menu-item-<?php echo get_the_ID(); ?>" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-<?php echo get_the_ID(); ?>">
		            		<a title="<?php echo get_the_title(); ?>" href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
		            	</li>
		            	<?php endwhile;?>
		            </ul>
            	</li>
            </ul>
		<?php endif;
        ?>
	</div>
	<div class="hamburger-col col-sm-3 col-md-3">
		<div class="guida-hamburger-menu-title">
			<h5>Classifiche</h5>
			<p class="triangle-down"></p>
		</div>
		<p class="aree-giuridiche">Aree giuridiche</p>
        <?php
            //var_dump($guida_items);
            if ($guida_items->have_posts()) :?>
            <ul class="hamburger-nav">
            	<li>
		            <ul role="menu" class="dropdown-menu">
		            	<?php while ( $guida_items->have_posts() ): $guida_items->the_post(); ?>
		            	<li id="menu-item-<?php echo get_the_ID(); ?>" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-<?php echo get_the_ID(); ?>"><a title="<?php echo get_the_title(); ?>" href="#"><?php the_title(); ?></a></li>
		            	<?php endwhile;  wp_reset_postdata();?>
		            </ul>
            	</li>
            </ul>
		<?php endif;
        ?>
	</div>
	<div class="hamburger-col col-sm-3 col-md-3">
		<div class="guida-hamburger-menu-title">
			<h5>Metodologia</h5>
			<p class="triangle-down"></p>
		</div>
        <?php
        wp_nav_menu(array(
	        'theme_location'    => 'guida-metodologia-menu',
	        'menu_class'        => 'hamburger-nav', //'nav navbar-nav meni'
	        'container'         => '',
	        'walker'            => new wp_bootstrap_navwalker()
        ));
        ?>
	</div>
	<div class="hamburger-col col-sm-3 col-md-3">
		<div class="guida-hamburger-menu-title">
			<h5>Partecipare</h5>
			<p class="triangle-down"></p>
		</div>
        <?php
        wp_nav_menu(array(
	        'theme_location'    => 'guida-partecipare-menu',
	        'menu_class'        => 'hamburger-nav', //'nav navbar-nav meni'
	        'container'         => '',
	        'walker'            => new wp_bootstrap_navwalker()
        ));
        ?>
	</div>
</div>