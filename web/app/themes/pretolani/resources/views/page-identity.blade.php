{{--
Template Name: Identity
--}}


@php $gallery = get_field('gallery_slider', $post->ID) @endphp


@extends('layouts.app')

@section('content')
<div class="onepage" id="main">
 @include('partials.loader')
 @include('partials.block-main-section')

 @if(!empty($gallery))
  <section class="page-section section section_gallery section-black">
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
          @foreach ($gallery as $g)
            <div class="swiper-slide">
              <div class="gallery-slide">
                <div class="gallery-slide__title">{!! $g['title'] !!}</div>
                <div class="gallery-slide__text">{!! $g['text'] !!}</div>
                <div class="gallery-slide__image"><img src="{{ $g['image'] }}"/></div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endif

  @include('partials.block-pages')
</div>
@endsection