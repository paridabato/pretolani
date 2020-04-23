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

  <?php get_template_part('partials/loader'); ?>

  <section class="page-section section section_creators">
    <div class="section__wrapper wrapper">
      <div class="flex-row flex-row_relative">
        <div class="flex-block title-wrap">
          <h1 class="section-title sep-letters">Identite</h1>
          <div class="description sep-lines">Lorem ipsum dolor sit amet, consectetur<br>adipiscing elit.</div>
        </div>
      </div>
    </div>
    <div class="fw-image-wrapper">
      <div class="fw-image fw-image_halfslide fw">
        <img src="<?php echo $tp ?>/images/identity-demo.png">
      </div>
    </div>
  </section>


  <section class="page-section section section-black">
    <div class="section__wrapper wrapper gallery-slider-wrap">
      <div class=" gallery-slider-nav">
        <div class="gallery-slider-nav__wrapper">
          <div class="gallery-slider-nav__arrow gallery-slider-nav__arrow-prev square-icon white"></div>
          <div class="swiper-pagination gallery-slider-nav__scrollbar white"></div>
          <div class="gallery-slider-nav__arrow gallery-slider-nav__arrow-next square-icon white"></div>
        </div>
      </div>
      <div class="swiper-container gallery-slider">
        <div class="swiper-wrapper">
          <?php for ($i = 0; $i < 5; $i++) : ?>
            <div class="swiper-slide">
              <div class="gallery-slide">
                <div class="gallery-slide__title">Naissance</div>
                <div class="gallery-slide__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lacinia
                  erat nec tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit lacinia erat nec tempus.
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit
                </div>
                <div class="gallery-slide__image"><img src="<?php echo $tp ?>/images/slide-demo.png"/></div>
              </div>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="page-section section section-black">
    <div class="section__wrapper wrapper">
      <div class="flex-row flex-row_swap demo-2">
        <div class="flex-block">
          <div class="bg-image bg-image_bottom"><img src="<?php echo $tp ?>/images/hand_x2.png"></div>
        </div>
        <div class="flex-block flex-block_text">
          <div class="flex-block__content">
            <div class="title-block c-white">
              <div class="section-title sep-letters">Equipes</div>
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
