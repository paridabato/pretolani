<?php get_header(); ?>

<?php

    global $tp;
    global $mob;

?>

<?php 
/*    set_query_var('addclass', 'no-bottom-padding');
    get_template_part('partials/text-block'); */
?>

<div class="onepage" id="main">

    <section class="page-section section section_nav section-black">
        <div class="section-slider-wrap fw">
            <div class="swiper-container section-slider">
                <div class="swiper-wrapper">
                    <?php for($i = 0; $i < 5; $i++) : ?>
                        <div class="swiper-slide">
                            <div class="section-slide">
                                <div class="section-slide__wrapper wrapper"><h2 class="section-slide__text section-title sep-letters">Projet<br>Particulier un</h2></div>
                                <img class="section-slide__image" src="<?php echo $tp ?>/img/slide-demo.png" />
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="section-slider-nav">
                <div class="section-slider-nav__wrapper wrapper">
                    <div class="section-slider-nav__arrow section-slider-nav__arrow-prev square-icon white"></div>
                    <div class="section-slider-nav__arrow section-slider-nav__arrow-next square-icon white"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <div class="flex-row">
                <div class="flex-block flex-block_padd">
                    <div class="flex-block__content">
                        <div class="description"><p class="sep-lines">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lacinia erat nec tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit  lacinia erat nec tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit</p></div>
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
    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <div class="flex-row flex-row_swap">
                <div class="flex-block">
                    <div class="bg-image bg-image_bottom"><img src="<?php echo $tp ?>/img/achiev-1.png"></div>
                </div>
                <div class="flex-block flex-block_text flex-block_bottom">
                    <div class="flex-block__content">
                        <div class="title-block c-white">
                            <div class="section-date wow fadeInUp" data-wow-delay="0.5s">2019</div>
                            <div class="section-title sep-letters">Project<br>DEUX</div>
                            <a class="title-link wow fadeInLeft" data-wow-delay="1s">Découvrir</a>
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

<?php get_footer(); ?>