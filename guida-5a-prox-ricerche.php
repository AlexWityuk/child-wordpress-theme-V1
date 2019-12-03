<?php
/*
Template Name: Guida 5a (Prox. ricerche) Toplegal
*/



get_header(); 
?>
<section class="content metodologia guida-page">
    <div class="container">
        <div class="" style="height: 80px;">
        </div>
        <div class="">
            <div class="col-md-2 left-column">
                <div class="row">
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
            </div>
            <div class="col-md-7 guida-list">
                <div class="row">
                    <div class="guida-title">
                        <div class="title">
                            <div class="name">
                                <h4>Piano delle ricerche</h4>
                            </div>
                        </div>
                   </div>
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                    the_content();
                    endwhile; else: ?>
                    <p>Sorry, no posts matched your criteria.</p>
                    <?php endif; ?>
                </div>
            </div><!--end col-md-5 guida-list-->
            <div class="col-md-3 right-col letters-rule-system">
                <div class="row" style="padding-left: 30px;">
                    <div class="guida-title">
                        <div class="title">
                            <div class="name">
                                <h4>Area personale</h4>
                            </div>
                        </div>
                   </div>
                    <p> 
                        Questa area è riservata al personale addetto al marketing e agli avvocati degli studi legali per 
                        consentire il caricamento del modulo digitale per la partecipazione alle ricerche di TopLegal.
                    </p>
                    <p>Sei già utente?</p>
                    <div class="tnnt btn" post-type="professionist" id="accedi"><a href="">Accedi</a></div>
                    <p id="registrato">Non sei registrato? Compila il modulo</p>
                    <div>
                        <p>Nome</p>
                        <p>Cognome</p>
                        <p>Posizione</p>
                        <p>Studio legale</p>
                        <p>Email</p>
                        <p>Password</p>
                    </div>
                    <div class="tnnt btn active" post-type="professionist" id="accedi"><a href="">Registrati</a></div>
                </div>
            </div><!--end col-md-3-->
        </div>
    </div>
</section>
<?php
get_footer('guida');