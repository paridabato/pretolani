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
            <section class="page-section section hide-logo">
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
            <section class="page-section section section-black ov-hidden">
                <div class="section__wrapper wrapper">
                    <div class="flex-row image-block-alt-wrap">
                        @php $it = 1; @endphp
                        @foreach($imageblocks['block'] as $block)
                            <div class="flex-block">
                                <div class="image-block-alt {{ ($it % 2 == 1) ? 'image-block-alt_top' : 'image-block-alt_bottom' }}">
                                    @if(!empty($block['image']))
                                        <div class="image-block__image">
                                            <img src="{{ $block['image'] }}" alt=" ">
                                        </div>
                                    @endif

                                    <div class="image-block__space"></div>

                                    <div class="image-block__description">

                                        @if(!empty($block['title']))
                                            <div class="image-block__title sep-letters">{{ $block['title'] }}</div>
                                        @endif

                                        @if(!empty($block['text']))
                                            <div class="image-block__text sep-lines">{!! $block['text'] !!}</div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            @php $it++; @endphp
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @include('partials.block-pages')
    </div>
@endsection
