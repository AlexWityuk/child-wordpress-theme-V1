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
            //var_dump($guida_items);
            if ($guida_items->have_posts()) :?>
            <ul class="hamburger-nav">
            	<li>
		            <ul role="menu" class="dropdown-menu">
		            	<?php while ( $guida_items->have_posts() ): $guida_items->the_post(); ?>
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