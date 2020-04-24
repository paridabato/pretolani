<header class="header fw">
  <div class="header__wrapper wrapper">
    <a class="header__logo logo" href="{{ home_url() }}" title="logo">{!! gv('logo') !!}</a>
    <div class="header__langs langs">{{ language_selector_flags() }}</div>
    <div class="header__menu-trigger menu-trigger">
      <div class="menu-trigger__lines"><i></i><i></i></div>
      <div class="menu-trigger__text">{{ __('MENU', 'sage') }}</div>
    </div>
  </div>
</header>
