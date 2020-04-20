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

    <?php get_template_part('partials/loader'); ?>

    <section class="page-section section section_nav section-black">
        <div class="section__wrapper wrapper">
            <div class="achievements-nav">
                <a class="achievements-nav__item achievements-nav__item_link achievements-nav__item_active title-link">Particuliers</a>
                <span class="achievements-nav__item achievements-nav__item_sep"></span>
                <a class="achievements-nav__item achievements-nav__item_link title-link" href="/category/achievements/professionals/">Professionnel</a>
            </div>
        </div>
    </section>
    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <div class="flex-row">
                <div class="flex-block">
                    <div class="bg-image bg-image_bottom"><img src="<?php echo $tp ?>/img/achiev-1.png"></div>
                </div>
                <div class="flex-block flex-block_text flex-block_bottom">
                    <div class="flex-block__content">
                        <div class="title-block c-white">
                            <div class="section-date wow fadeInUp" data-wow-delay="0.5s">2019</div>
                            <div class="section-title sep-letters">Project<br>Un</div>
                            <a class="title-link wow fadeInLeft" data-wow-delay="1s">Découvrir</a>
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
    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <div class="flex-row">
                <div class="flex-block">
                    <div class="bg-image bg-image_bottom"><img src="<?php echo $tp ?>/img/achiev-1.png"></div>
                </div>
                <div class="flex-block flex-block_text flex-block_bottom">
                    <div class="flex-block__content">
                        <div class="title-block c-white">
                            <div class="section-date wow fadeInUp" data-wow-delay="0.5s">2019</div>
                            <div class="section-title sep-letters">Project<br>Trois</div>
                            <a class="title-link wow fadeInLeft" data-wow-delay="1s">Découvrir</a>
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
                            <div class="section-title sep-letters">Project<br>Quatre</div>
                            <a class="title-link wow fadeInLeft" data-wow-delay="1s">Découvrir</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    </section>

    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <a class="back-to-top">
                <span class="back-to-top__icon square-icon"></span>
                <span class="back-to-top__text">Retour en haut</span>
            </a>
        </div>
    </section>
</div>

<style>
    body {
        overflow: hidden;
    }
</style>

<?php get_footer(); ?>