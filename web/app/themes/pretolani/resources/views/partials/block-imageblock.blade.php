@if(empty($imageblocks))
	@php $imageblocks = get_field('image_blocks', $post->ID) @endphp
@endif

@if(!empty($imageblocks['block']))
	@foreach($imageblocks['block'] as $block)
		<section class="page-section section section-{{ $block['background'] }}">
		    <div class="section__wrapper">
		        <div class="flex-row @if($block['swap_position']) flex-row_swap @endif">
		            <div class="flex-block">
		            	@if(!empty($block['image']))
		                	<div class="bg-image"><img src="{{ $block['image'] }}"></div>
		                @endif
		            </div>
		            <div class="flex-block flex-block_text">
		                <div class="flex-block__content">
		                    <div class="title-block">
		                    	@if(!empty($block['image']))
		                        	<div class="section-title sep-letters">{{ $block['title'] }}</div>
		                        @endif

		                        @if(!empty($block['image']))
		                        	<a class="title-link wow fadeInLeft" data-wow-delay="1s" href="{{ $block['link']['url'] }}">{{ $block['link']['title'] }}</a>
		                        @endif
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</section>
	@endforeach
@endif