<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @yield('meta')

  {{-- WEB MANIFEST --}}
  {{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ get_stylesheet_directory_uri() . '/assets/images/webmanifest/apple-touch-icon.png' }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ get_stylesheet_directory_uri() . '/assets/images/webmanifest/favicon-32x32.png' }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ get_stylesheet_directory_uri() . '/assets/images/webmanifest/favicon-16x16.png' }}">
  <link rel="manifest" href="{{ get_stylesheet_directory_uri() . '/site.webmanifest' }}">
  <link rel="mask-icon" href="{{ get_stylesheet_directory_uri() . '/assets/images/webmanifest/safari-pinned-tab.svg' }}" color="#0e0e0e">
  <meta name="msapplication-config" content="{{ get_stylesheet_directory_uri() . '/browserconfig.xml' }}" />
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff"> --}}

  @if (GOOGLE_ANALYTICS_TRACKING_ID)
    <script id="gdpr-analytics" data-src="https://www.googletagmanager.com/gtag/js?id={{ GOOGLE_ANALYTICS_TRACKING_ID }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ GOOGLE_ANALYTICS_TRACKING_ID }}');
    </script>
  @endif
  <script src="https://www.google.com/recaptcha/api.js?render={{ RECAPTCHA_PUBLIC_KEY }}"></script>
  @php wp_head() @endphp

  {{-- ADD SCHEMA LOCAL SEO --}}
  @if (is_front_page() && function_exists('get_field'))
    @include('components.schema-local-seo')
  @endif
</head>
