@empty($pages)
	@php $pages = get_field('pages', $post->ID); $pages = $pages['pages'] @endphp
@endempty

@if(!empty($pages))
	@foreach($pages as $p)
		@php $page = $p['page'] @endphp
		<section class="page-section section section-{{ $p['background'] }}">
		    <div class="section__wrapper">
		        <div class="flex-row @if($p['swap_position']) flex-row_swap @endif">
		            <div class="flex-block">
		                <div class="bg-image"><img src="{{ get_the_post_thumbnail_url($page, 'full') }}"></div>
		            </div>
		            <div class="flex-block flex-block_text">
		                <div class="flex-block__content">
		                    <div class="title-block">
	                        	<div class="section-title sep-letters">{{ $page->post_title }}</div>
		                        <a class="title-link wow fadeInLeft" data-wow-delay="1s" href="{{ get_permalink($page) }}">{{ __('Découvrir', 'sage') }}</a>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</section>
	@endforeach
@endif