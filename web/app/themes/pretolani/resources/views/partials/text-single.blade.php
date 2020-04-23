@php 
	if(empty($text_single)) {
    	$text_single = get_field('text_single', $post->ID);
	}
@endphp

@php if(!empty($text_single['text']) || !empty($text_single['author'])) : @endphp
<section class="page-section section">
    <div class="section__wrapper wrapper">
        <div class="t-center description">

        	@php if(!empty($text_single['text'])) : @endphp
            	<h2 class="sep-lines t-normal title">@php echo $text_single['text'] @endphp</h2>
            @php endif; @endphp

            @php if(!empty($text_single['author']) ) : @endphp
            	<p class="sep-lines">@php echo $text_single['author'] @endphp</p>
            @php endif; @endphp

        </div>
    </div>
</section>
@php endif; @endphp