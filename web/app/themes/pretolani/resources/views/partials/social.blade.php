@php 
    $email = get_field('email', 'options');
    $soc = get_field('socials', 'options');
@endphp

<div class="social-block">
	@php if(!empty($email)) : @endphp
    	<div class="social-block__title-link title-link  wow fadeInLeft" data-wow-delay="1s">
    		<div class="title-link__text">Demander un devis</div>
    		<div class="title-link__hint">
	    		<div class="title-link__hint-inner">
	    			<a charset="title-link__hint-item" href="mailto:@php echo $email @endphp">@php echo $email @endphp</a>
	    		</div>
    		</div>
    	</div>
    @php endif; @endphp
    @php if(!empty($soc)) : @endphp
        <div class="social-block__block">
            @php foreach($soc as $s) : @endphp
                <a class="social-link sep-letters" href="@php echo $s['link']['url'] @endphp" target="@php echo $s['link']['target'] @endphp">@php echo $s['link']['title'] @endphp</a>
            @php endforeach; @endphp
        </div>
    @php endif; @endphp
</div>