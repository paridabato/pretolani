@php 
	if(empty($mainblock)) {
    	$mainblock = get_field('main_block', $post->ID);
	}
@endphp

<section class="page-section section section_creators">
    <div class="section__wrapper wrapper">
        <div class="flex-row flex-row_relative">
            <div class="flex-block">
            	@php if(!empty($mainblock['title'])) : @endphp
                	<h1 class="section-title sep-letters">@php echo $mainblock['title']; @endphp</h1>
                @php endif @endphp
            </div>
            <div class="flex-block flex-block_padd">
                <div class="flex-block__content">
                	@php if(!empty($mainblock['text'])) : @endphp
                    	<div class="quote-text description sep-lines">@php echo $mainblock['text']; @endphp</div>
                    @php endif @endphp
                </div>
            </div>
        </div>
    </div>
    @php if(!empty($mainblock['image'])) : @endphp
    <div class="fw-image-wrapper">
        <div class="fw-image fw-image_halfslide fw">
            <img src="@php echo $mainblock['image']; @endphp">
        </div>
    </div>
    @php endif @endphp
</section>