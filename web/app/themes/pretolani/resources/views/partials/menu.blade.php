@php global $tp; @endphp
<div class="menu fw">
  <div class="menu__wrapper wrapper">
    <div class="menu__links">
      <div class="menu__block menu__block_images">
        <img src="@php echo $tp; @endphp/img/menu-image-demo.png"/>
        <img src="@php echo $tp; @endphp/img/menu-image-demo.png"/>
        <img src="@php echo $tp; @endphp/img/menu-image-demo.png"/>
        <img src="@php echo $tp; @endphp/img/menu-image-demo.png"/>
        <img src="@php echo $tp; @endphp/img/menu-image-demo.png"/>
      </div>
      <div class="menu__block menu__block_nav">
        @php
        wp_nav_menu(array(
          'container' => '',
          'theme_location' => 'main_menu',
          'menu_class' => 'menu__nav',
          'depth' => 0,
        ));
        @endphp
      </div>
      <div class="menu__block"></div>
    </div>
    <div class="menu__sub">
      <div class="menu__sub-block">
        <a href="/mentions-legales/">Mentions légales</a>
      </div>
      <div class="menu__sub-block menu__sub-block_social">
        <a href="#">Instagram</a>
        <a href="#">Facebook</a>
      </div>
    </div>
  </div>
</div>
