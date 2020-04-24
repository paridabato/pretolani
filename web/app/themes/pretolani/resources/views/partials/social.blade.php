@php 
    $email = get_field('email', 'options');
    $soc = get_field('socials', 'options');
@endphp

<div class="social-block">
	@if(!empty($email))
    	<div class="social-block__title-link title-link  wow fadeInLeft" data-wow-delay="1s">
    		<div class="title-link__text">{{ __('Demander un devis', 'sage') }}</div>
    		<div class="title-link__hint">
	    		<div class="title-link__hint-inner">
	    			<a charset="title-link__hint-item" href="mailto:{{ $email }}">{{ $email }}</a>
	    		</div>
    		</div>
    	</div>
    @endif
    @if(!empty($soc))
        <div class="social-block__block">
            @foreach($soc as $s)
                <a class="social-link sep-letters" href="{{ $s['link']['url'] }}" target="{{ $s['link']['target'] }}">{{ $s['link']['title'] }}</a>
            @endforeach
        </div>
    @endif
</div>