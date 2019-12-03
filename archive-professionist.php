<?php
/*
Professionist Post Type Archive
*/
get_header(); 
?>
<section class="content">
    <div class="container">
    	<div class="row prof-arch-tit">
	    	<div class="col-sm-6 col-md-9">
	    		<h1 id="allen-overy">Roberto Bonsignore</h1>
				<div class="title">
                    <h4>Cleary Gottlieb Steen & Hamilton</h4>
				</div>
	    	</div>
	    	<div class="col-sm-6 col-md-3">
	    	</div>
    	</div>
		<div class="col-sm-6 col-md-6 rnking-std-list left">
			<div class="row">
	    		<div class="title">
	                <div class="name">
	                    <h4>Guida Toplegal</h4>
	                </div>
				</div>
    			<div class="ctname">
			        <div class="name">
			            <h4>Ranking professionista</h4>
			        </div>
				</div>
				<ul>
					<li class="title">
	                    <h4>Amministrativo</h4>
	                    <div>
		                    <h5>Contenzioso</h5>
	                    	<span>(Fascia 3)</span>
	                    </div>
					</li>
					<li class="title">
	                    <h4>Capital Markets</h4>
	                    <div>
		                    <h5>Debt Capital Markets</h5>
	                    	<span>(Fascia 1)</span>
	                    </div>
	                    <div>
		                    <h5>Cartolarizzazioni</h5>
	                    	<span>(Fascia 2)</span>
	                    </div>
					</li>
					<li class="title">
	                    <h4>Contenzioso</h4>
	                    <div>
		                    <h5>Banking, Finance, Assicurativo</h5>
	                    	<span>(Fascia 1)</span>
	                    </div>
					</li>
					<li class="title">
	                    <h4>Tax</h4>
	                    <div>
		                    <h5>Operazioni Straordinare</h5>
	                    	<span>(Fascia 3)</span>
	                    </div>
	                    <div>
		                    <h5>Finanza</h5>
	                    	<span>(Fascia 1)</span>
	                    </div>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-sm-6 col-md-6 rnking-std-list right">
			<div class="row">
			 	<?php if ( is_active_sidebar( 'archive-bottom-sidebar' ) ) : ?>
					<?php dynamic_sidebar( 'archive-bottom-sidebar' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();