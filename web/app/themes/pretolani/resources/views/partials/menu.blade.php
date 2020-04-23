@php 
    $soc = get_field('socials', 'options');
    $menu = get_field('menu', 'options');
@endphp

<div class="menu fw">
    <div class="menu__wrapper wrapper">
        <div class="menu__links">
            <div class="menu__block menu__block_images">
                @php if(!empty($menu['images'])) : @endphp
                    @php foreach($menu['images'] as $i) : @endphp
                        <img src="@php echo $i; @endphp"/>
                    @php endforeach; @endphp
                @php endif; @endphp
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
                @php if(!empty($menu['links'])) : @endphp
                    @php foreach($menu['links'] as $l) : @endphp
                    <a href="@php echo $l['link']['url']; @endphp">@php echo $l['link']['title']; @endphp</a>
                    @php endforeach; @endphp
                @php endif; @endphp
            </div>

            @php if(!empty($soc)) : @endphp
                <div class="menu__sub-block menu__sub-block_social menu-social">
                    @php foreach($soc as $s) : @endphp
                        <a class="menu-social__link" href="@php echo $s['link']['url'] @endphp" target="@php echo $s['link']['target'] @endphp">@php echo $s['link']['title'] @endphp</a>
                    @php endforeach; @endphp
                </div>
            @php endif; @endphp
        </div>
    </div>
</div>
