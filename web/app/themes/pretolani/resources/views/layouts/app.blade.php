<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @include('partials.header')
    @yield('content')
    @if (App\display_sidebar())
      <aside class="sidebar">
        @include('partials.sidebar')
      </aside>
    @endif
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @include('components.gdpr')
    @php wp_footer() @endphp
  </body>
</html>