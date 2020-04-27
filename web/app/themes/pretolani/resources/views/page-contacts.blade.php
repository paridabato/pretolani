{{--
Template Name: Contacts
--}}

@extends('layouts.app')

@section('content')
    <div class="onepage" id="main">
        @include('partials.loader')
        <section class="page-section section section-black">
            <div class="section__wrapper wrapper">
                <div class="flex-row">
                    <div class="flex-block title-wrap title-wrap_top">
                        <h1 class="section-title sep-letters">{!! App::title() !!}</h1>
                        <div class="description sep-lines">{{ the_content() }}</div>
                    </div>
                    <div class="flex-block flex-block_padd"><div class="flex-block__content">@include('partials.social')</div></div>
                </div>
            </div>
        </section>
    </div>
@endsection