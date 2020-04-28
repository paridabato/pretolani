@extends('layouts.app')
@section('content')
  <div class="onepage" id="main">
    <section class="page-section section section_logo">
      <div class="section__wrapper wrapper">
        <div class="logo-wrap">
          <div class="logo-wrap__block">
            <div class="logo-wrap__block-title">{{ __('Erreur 404', 'sage') }}</div>
            <a class="logo-wrap__block-text title-link" href="@php echo home_url(); @endphp">{{ __('Retour au site', 'sage') }}</a>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
