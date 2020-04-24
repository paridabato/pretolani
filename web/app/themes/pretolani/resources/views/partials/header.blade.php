<header class="header fw">
  <div class="header__wrapper wrapper">
    <a class="header__logo logo" href="@php echo home_url();@endphp" title="logo">@php echo gv('logo');@endphp</a>
    <div class="header__langs langs">@php echo language_selector_flags();@endphp</div>
    <div class="header__menu-trigger menu-trigger">
      <div class="menu-trigger__lines"><i></i><i></i></div>
      <div class="menu-trigger__text">MENU</div>
    </div>
  </div>
</header>
