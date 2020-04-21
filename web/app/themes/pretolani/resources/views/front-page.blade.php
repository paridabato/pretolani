@extends('layouts.app')

@php
    global $tp;
    global $mob;
@endphp

@section('content')
  <div id="main">
    @include('partials.loader')

    <section class="page-section section section_creators">
      <div class="section__wrapper wrapper">
        <div class="flex-row flex-row_relative">
          <div class="flex-block">
            <h1 class="section-title sep-letters">Createur<br>de mobiliers<br>depius 1986</h1>
          </div>
          <div class="flex-block flex-block_padd">
            <div class="flex-block__content">
              <div class="quote-text description sep-lines">Depuis 1986, Pretolani Agencement concrétise des projets luxueux de grands architectes et décorateurs qui font appel à son savoir-faire d’excellence.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="fw-image-wrapper">
        <div class="fw-image fw-image_halfslide fw">
          <img src="@php echo $tp; @endphp/img/pen.png">
        </div>
      </div>
    </section>
    <section class="page-section section">
      <div class="section__wrapper wrapper">
        <div class="t-center description">
          <h2 class="sep-lines t-normal title">Lorem ipsum dolor sit amet consectetur<br>adipiscing elit. Donec lacinia erat nec tempus.<br>Lorem ipsum dolor  sit amet consectetur.<br>Lorem ipsum dolor</h2>
          <p class="sep-lines">Damien pretolani</p>
        </div>
      </div>
    </section>
    <section class="page-section section section-black">
      <div class="section__wrapper wrapper">
        <div class="flex-row demo-2">
          <div class="flex-block">
            <div class="bg-image bg-image_bottom"><img src="@php echo $tp; @endphp/img/hand_x2.png"></div>
          </div>
          <div class="flex-block flex-block_text flex-block_bottom">
            <div class="flex-block__content">
              <div class="title-block c-white">
                <div class="section-title sep-letters">Identite</div>
                <a class="title-link wow fadeInLeft" data-wow-delay="1s">Découvrir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="page-section section section-black">
      <div class="section__wrapper wrapper">
        <div class="flex-row flex-row_swap demo-2">
          <div class="flex-block">
            <div class="bg-image bg-image_bottom"><img src="@php echo $tp; @endphp/img/chertezh.png"></div>
          </div>
          <div class="flex-block flex-block_text flex-block_bottom">
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
@endsection
