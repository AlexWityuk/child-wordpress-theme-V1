<?php
/*
Template Name: Guida 4 (Metodologia) Toplegal
*/



get_header(); 
?>
<section class="content metodologia guida-page">
    <div class="container">
        <div class="" style="height: 80px;">
        </div>
        <div class="">
            <div class="col-md-3 left-column">
                <div class="title contattaci">
                    <div class="name">
                        <h4>Contatti</h4>
                    </div>
                </div>
                <div class="academy">
                    <div class="title">
                        <div class="name">
                            <h4>Responsable riceche</h4>
                        </div>
                    </div>
                </div>
                <p id="name">Nuova risorsa</p>
                <p id="phone">02.87084121</p>
                <p id="email">mmarketing@toplegal.it</p>
            </div>
            <div class="col-md-9 guida-list">
                <div class="row">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                    the_content();
                    endwhile; else: ?>
                    <p>Sorry, no posts matched your criteria.</p>
                    <?php endif; ?>
                </div>
            </div><!--end col-md-8 guida-list-->
        </div>
    </div>
</section>
<?php
get_footer('guida');