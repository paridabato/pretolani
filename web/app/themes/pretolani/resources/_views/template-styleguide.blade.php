{{--
  Template Name: Styleguide Template
--}}

@extends('layouts.app')

@section('meta')
  <meta name="robots" content="noindex,follow">
@endsection

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @endwhile
@endsection
