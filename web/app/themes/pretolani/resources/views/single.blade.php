@php
	$slider = get_field('slider', $post->ID);
@endphp

@extends('layouts.app')

@section('content')
<div class="onepage" id="main">

	@if(!empty($slider))
	    <section class="page-section section section_nav section-black">
	        <div class="section-slider-wrap fw">
	            <div class="swiper-container section-slider">
	                <div class="swiper-wrapper">
	                    @foreach($slider as $s)
	                        <div class="swiper-slide">
	                            <div class="section-slide">
	                                <div class="section-slide__wrapper wrapper"><h2 class="section-slide__text section-title sep-letters">{{ $s['title'] }}</h2></div>
	                                <img class="section-slide__image" src="{{ $s['image'] }}" />
	                            </div>
	                        </div>
	                    @endforeach
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
    @endif
    
    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <div class="flex-row">
                <div class="flex-block flex-block_padd">
                    <div class="flex-block__content">
                        <div class="description sep-lines">@php the_content() @endphp</div>
                    </div>
                </div>
                <div class="flex-block flex-block_padd">
                    <div class="flex-block__content">@include('partials.social')</div>
                </div>
            </div>
        </div>
    </section>

    @php
    	//$p = get_next_post(true);
    	$p = get_previous_post();
    @endphp

    @if(!empty($p))
	    <section class="page-section section">
	        <div class="section__wrapper wrapper">
	            <div class="flex-row flex-row_swap">
	                <div class="flex-block">
	                    <div class="bg-image bg-image_bottom"><img src="{{ get_the_post_thumbnail_url($p->ID) }}"></div>
	                </div>
	                <div class="flex-block flex-block_text flex-block_bottom">
	                    <div class="flex-block__content">
	                        <div class="title-block c-white">
	                            <div class="section-date wow fadeInUp" data-wow-delay="0.5s">{{ get_the_date('Y', $p->ID) }}</div>
	                            <div class="section-title sep-letters">{{ $p->post_title }}</div>
	                            <a class="title-link wow fadeInLeft" data-wow-delay="1s" href="{{ get_permalink($p->ID) }}">Découvrir</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            </div>
	    </section>
    @endif
</div>

@endsection