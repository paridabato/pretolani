@php 
	if(empty($imageblocks)) {
    	$imageblocks = get_field('image_blocks', $post->ID);
	}
@endphp

@php if(!empty($imageblocks['block'])) : @endphp
	@php foreach($imageblocks['block'] as $block) : @endphp
		<section class="page-section section section-@php echo $block['background'] @endphp">
		    <div class="section__wrapper">
		        <div class="flex-row @php if($block['swap_position']) : @endphp flex-row_swap @php endif @endphp">
		            <div class="flex-block">
		            	@php if(!empty($block['image'])) : @endphp
		                	<div class="bg-image"><img src="@php echo $block['image'] @endphp"></div>
		                @php endif @endphp
		            </div>
		            <div class="flex-block flex-block_text">
		                <div class="flex-block__content">
		                    <div class="title-block">
		                    	@php if(!empty($block['image'])) : @endphp
		                        	<div class="section-title sep-letters">@php echo $block['title'] @endphp</div>
		                        @php endif @endphp

		                        @php if(!empty($block['image'])) : @endphp
		                        	<a class="title-link wow fadeInLeft" data-wow-delay="1s" href="@php echo $block['link']['url'] @endphp">@php echo $block['link']['title'] @endphp</a>
		                        @php endif @endphp
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</section>
	@php endforeach @endphp
@php endif @endphp