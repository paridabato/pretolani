{{--
Template Name: Teams
--}}

@php $gallery = get_field('gallery_slider', $post->ID) @endphp
@php $imageblocks = get_field('image_block', $post->ID) @endphp

@extends('layouts.app')
@section('content')
    <div class="onepage" id="main">
        @include('partials.loader')
        @include('partials.block-main-section')

        @if(!empty($gallery))
            <section class="page-section section">
                <div class="section__wrapper wrapper gallery-slider-wrap">
                    <div class="gallery-slider-nav">
                        <div class="gallery-slider-nav__wrapper">
                            <div class="gallery-slider-nav__arrow gallery-slider-nav__arrow-prev square-icon"></div>
                            <div class="swiper-pagination gallery-slider-nav__scrollbar"></div>
                            <div class="gallery-slider-nav__arrow gallery-slider-nav__arrow-next square-icon"></div>
                        </div>
                    </div>
                    <div class="swiper-container gallery-slider-alt">
                        <div class="swiper-wrapper">
                            @foreach ($gallery as $g)
                                <div class="swiper-slide">
                                    <div class="gallery-slide-alt"><img src="{{ $g['url'] }}" alt=""/></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if(!empty($imageblocks['block']))
            @foreach($imageblocks['block'] as $block)
                <section class="page-section section section-{{ $block['background'] }}">
                    <div class="section__wrapper wrapper">
                        <div class="flex-row @if($block['swap_position']) flex-row_swap @endif">
                            <div class="flex-block">
                                <div class="image-block">
                                    @if(!empty($block['image']))
                                        <div class="image-block__image">
                                            <img class="wow fadeInRight" data-wow-delay="1.5s" src="{{ $block['image'] }} alt="">
                                        </div>
                                    @endif

                                    @if(!empty($block['title']))
                                        <div class="image-block__title sep-letters">{{ $block['title'] }}</div>
                                    @endif

                                    @if(!empty($block['text']))
                                        <div class="image-block__text sep-lines">{!! $block['text'] !!}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-block"></div>
                        </div>
                    </div>
                </section>
            @endforeach
        @endif

        @include('partials.block-pages')
    </div>
@endsection
