@extends('layouts.app')

@php
    $tp = get_template_directory_uri() . '/assets/images';
@endphp

@section('content')
<div class="onepage" id="main">
    @include('partials.loader')
    <section class="page-section section section_nav section-black">
        <div class="section__wrapper wrapper">
            <div class="achievements-nav">
                <a class="achievements-nav__item achievements-nav__item_link achievements-nav__item_active title-link">{{ __('Particuliers', 'sage') }}</a>
                <span class="achievements-nav__item achievements-nav__item_sep"></span>
                <a class="achievements-nav__item achievements-nav__item_link title-link" href="/category/achievements/professionals/">{{ __('Professionnel', 'sage') }}</a>
            </div>
        </div>
    </section>
    @while ( have_posts() ) : the_post();
        <section class="page-section section">
            <div class="section__wrapper wrapper">
                <div class="flex-row">
                    <div class="flex-block">
                        <div class="bg-image bg-image_bottom"><img src="{{ get_the_post_thumbnail_url() }}"></div>
                    </div>
                    <div class="flex-block flex-block_text flex-block_bottom">
                        <div class="flex-block__content">
                            <div class="title-block c-white">
                                <div class="section-date wow fadeInUp" data-wow-delay="0.5s">@php the_date('Y') @endphp</div>
                                <div class="section-title sep-letters">@php the_title() @endphp</div>
                                <a class="title-link wow fadeInLeft" data-wow-delay="1s" href="@php echo get_permalink() @endphp ">Découvrir</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </section>
    @endwhile


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

@endsection
