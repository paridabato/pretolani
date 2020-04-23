<?php
/*
Template Name: Mentions Legales
*/
?>

<?php get_header();?>

<?php

    global $tp;
    global $mob;
?>

<div class="onepage" id="main">
    <?php get_template_part('partials/loader');?>
    <section class="page-section section section-black">
        <div class="section__wrapper wrapper">
            <div class="flex-row">
                <div class="flex-block title-wrap title-wrap_top">
                    <h1 class="section-title sep-letters">Mentions<br>Legales</h1>
                    <div class="description sep-lines">Lorem ipsum dolor sit amet,</div>
                </div>
                <div class="flex-block flex-block_padd">
                    <div class="flex-block__content">
                        <div class="description sep-lines">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur nulla dui, maximus sit amet consectetur ut, consectetur a dolor. Praesent non arcu finibus, hendrerit nibh a, ultricies felis. Pellentesque iaculis ac diam sit amet feugiat. Quisque auctor odio eu purus fermentum, ac sagittis purus tincidunt. Praesent risus lacus, consectetur vitae urna quis, posuere laoreet mauris. Nunc tincidunt nunc sapien, sit amet blandit ante tempus eu. Sed rhoncus tortor elit, eu finibus mauris laoreet sed. Vivamus vehicula, quam blandit congue tincidunt, eros eros condimentum est, ac dapibus quam tortor at magna.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    body {
        overflow: hidden;
    }
</style>

<?php get_footer();?>
