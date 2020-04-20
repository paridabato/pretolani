<?php
/*
Template Name: Identity
*/
?>

<?php get_header(); ?>

<?php

    global $tp;
    global $mob;

?>

<div class="onepage" id="main">
    <section class="page-section section section_logo">
        <div class="section__wrapper wrapper">
            <div class="logo-wrap">
                <div class="logo-wrap__block">
                    <div class="logo-wrap__block-title">Erreur 404</div>
                    <a class="logo-wrap__block-text title-link" href="<?php echo home_url(); ?>">Retour au site</a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    body {
        overflow: hidden;
    }

    .header,
    #fp-nav {
        display: none;
    }
</style>

<?php get_footer(); ?>
