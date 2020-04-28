@php 
    $soc = get_field('socials', 'options');
    $menu = get_field('menu', 'options');
@endphp

<div class="menu fw">
    <div class="menu__wrapper wrapper">
        <div class="menu__links">
            <div class="menu__block menu__block_images">
                @if(!empty($menu['images']))
                    @foreach($menu['images'] as $i)
                        <img src="{{ $i }}"/>
                    @endforeach
                @endif
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
        <div class="mobile-langs">{{ language_selector_flags() }}</div>
        <div class="menu__sub">
            <div class="menu__sub-block">
                @if(!empty($menu['links']))
                    @foreach($menu['links'] as $l)
                    <a href="{{ $l['link']['url'] }}">{{ $l['link']['title'] }}</a>
                    @endforeach
                @endif
            </div>

            @if(!empty($soc))
                <div class="menu__sub-block menu__sub-block_social menu-social">
                    @foreach($soc as $s)
                        <a class="menu-social__link" href="{{ $s['link']['url'] }}" target="{{ $s['link']['target'] }}">{{ $s['link']['title'] }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
