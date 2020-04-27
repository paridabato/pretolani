@extends('layouts.app')

@section('content')
    <div id="main">
        @include('partials.loader')
        @include('partials.block-main-section')
        @include('partials.text-single')
        @include('partials.block-pages')
    </div>
@endsection
