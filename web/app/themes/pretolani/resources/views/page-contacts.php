<?php
/*
Template Name: Contacts
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
                    <h1 class="section-title sep-letters">Contact</h1>
                    <div class="description sep-lines">
                        <p>52 Avenue de Condé, </p>
                        <p>94100 Saint-Maur-des-Fossés</p>
                        <p>01 42 83 36 56</p>
                    </div>
                </div>
                <div class="flex-block flex-block_padd">
                    <div class="flex-block__content">
                        <div class="social-block">
                            <a class="social-block__title-link title-link  wow fadeInLeft" data-wow-delay="1s">Demander un devis</a>
                            <div class="social-block__block">
                                <a class="social-link sep-letters" href="#" target="_blank">Instagram</a>
                                <a class="social-link sep-letters" href="#" target="_blank">Facebook</a>
                            </div>
                        </div>
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
