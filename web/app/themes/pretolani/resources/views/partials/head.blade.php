@php
global $tp;
$tp = get_template_directory_uri();
global $mob;
$mob = wp_is_mobile();
global $logo;
$logo = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 346.2 47.97"><defs><style>.cls-1{fill:#1d1d1b;}</style></defs><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Logo"><path class="cls-1" d="M0,0V48H25.06L48.91,24.13V0ZM43.93,24v1.19H24V43.06H4.92V5h39Z"/><polygon class="cls-1" points="139.08 9.99 160.1 9.99 160.1 16.1 145.03 16.1 145.03 21.09 158.19 21.09 158.19 25.93 144.95 25.93 144.95 32.03 160.1 32.03 160.1 37.98 139.08 37.98 139.08 9.99"/><polygon class="cls-1" points="168.09 9.99 191.1 9.99 191.1 16.1 183.01 16.1 183.01 37.98 177.15 37.98 177.15 16.18 168.09 16.18 168.09 9.99"/><path class="cls-1" d="M213.52,9.82A14.17,14.17,0,1,0,227.68,24,14.16,14.16,0,0,0,213.52,9.82Zm0,22.27a8.1,8.1,0,1,1,8.1-8.1A8.11,8.11,0,0,1,213.52,32.09Z"/><polygon class="cls-1" points="238.89 9.99 238.89 37.98 258.24 37.98 258.24 32.12 245.02 32.12 245.02 9.99 238.89 9.99"/><polygon class="cls-1" points="304.33 9.99 310.36 9.99 322.2 25.24 322.2 9.99 329.07 9.99 329.07 37.98 323.37 37.98 311.42 22.05 311.31 37.98 304.33 37.98 304.33 9.99"/><polygon class="cls-1" points="340.18 9.99 346.2 9.99 346.2 37.98 340.18 38.15 340.18 9.99"/><path class="cls-1" d="M88.89,10H74V38h6V29.1h8.88s7-.79,7-9A10,10,0,0,0,88.89,10ZM86.27,23.07H80V16.15h6.23C91.93,20.06,86.27,23.07,86.27,23.07Z"/><path class="cls-1" d="M122.83,27.28s5.15.87,5.15-8.41S121,10,121,10H105.15V38h7v-9h3.81l6,9h7V36.24Zm-4.73-4.21h-5.92V16.15h5.92C125.76,19.85,118.1,23.07,118.1,23.07Z"/><path class="cls-1" d="M283.51,10h-6.24L266,38l6.23.17,3-7.09h10.79L288.69,38H295Zm-6.4,15.94c.11-.21,3.38-8,3.38-8l3.23,8Z"/></g></g></g></svg>';
@endphp

<head>
  <meta charset="@php bloginfo('charset'); @endphp">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <link rel="shortcut icon" href="@php echo $tp; @endphp>/favicon.ico" type="image/x-icon">
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
