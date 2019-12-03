<?php
/*
Template Name: Homepage Full width No Sidebar 
*/



get_header(); 
?>
<section class="content">
        <div class="container">
	 		<div class="row">
		 		 <?php if ( is_active_sidebar( 'homepage-fullwidth-top' ) ) : ?>
		                <?php dynamic_sidebar( 'homepage-fullwidth-top' ); ?>
	             <?php endif; ?>
   			</div>
   			<div class="row">   				
   				<div class="col-md-8">
		 		 <?php if ( is_active_sidebar( 'homepage-fullwidth-left' ) ) : ?>
	                <?php dynamic_sidebar( 'homepage-fullwidth-left' ); ?>
             	<?php endif; ?>             
             	</div>
	            <div class="col-md-4">
	               <?php if ( is_active_sidebar( 'homepage-fullwidth-right' ) ) : ?>
	                <?php dynamic_sidebar( 'homepage-fullwidth-right' ); ?>
             	<?php endif; ?>
	        	</div>
   			</div>
            <div class="row">
                <div class="col-md-12  main-content">
	                <?php if ( is_active_sidebar( 'homepage-central-column' ) ) : ?>
		                <?php dynamic_sidebar( 'homepage-central-column' ); ?>
	                <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

	

<?php if ( is_active_sidebar( 'footer-masonry-sidebar' )) { ?>
		<section class="content">
		<div class="section">
			<div class="container">
			
					
					<div id="footerMasonry"  class="row">
						<?php dynamic_sidebar( 'footer-masonry-sidebar'  ); ?>
					</div>
					
				
			</div>
		</div>
		</section>
<?php } ?>

		<section class="content homepage-fullwidth-bottom">
	        <div class="container">
		 		<div class="row">  				
	   				<div class="col-md-6 no-padding-left">
			 		 <?php if ( is_active_sidebar( 'homepage-fullwidth-bottom-left' ) ) : ?>
		                <?php dynamic_sidebar( 'homepage-fullwidth-bottom-left' ); ?>
	             	<?php endif; ?>             
	             	</div>
		            <div class="col-md-6 no-padding-right">
		               <?php if ( is_active_sidebar( 'homepage-fullwidth-bottom-right' ) ) : ?>
		                <?php dynamic_sidebar( 'homepage-fullwidth-bottom-right' ); ?>
	             	<?php endif; ?>
		        	</div>
	   			</div>
	   		</div>
	   	</section>

<?php if ( is_active_sidebar( 'before-footer-sidebar' )) { ?>
	<section class="content">
        <div class="container">
			<?php dynamic_sidebar( 'before-footer-sidebar' ); ?>
		</div>
	</section>
<?php } ?>
<?php 
get_footer();
?>