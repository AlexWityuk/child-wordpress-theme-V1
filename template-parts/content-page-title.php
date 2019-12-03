<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package tecnavia
 */
?>
    <div>
        <div style="margin-bottom:10px;margin-top:0;margin-right: 6px;" class="analisi mrkt2 att hidden-xs">
            <div class="wrap">
                <i class="fa fa-bookmark" aria-hidden="true"></i> 
                <span><?php the_title(); ?></span>
                <div class="arr-down"></div>
            </div>  
        </div>
        <div class="pg-temp-cont">
            <?php the_content(); ?>
        </div>
    </div>