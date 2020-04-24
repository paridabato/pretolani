@if(empty($mainblock))
  @php $mainblock = get_field('main_block', $post->ID); @endphp
@endif

<section class="page-section section section_creators">
    <div class="section__wrapper wrapper">
        <div class="flex-row flex-row_relative">
            <div class="flex-block">
            	@if(!empty($mainblock['title']))
                	<h1 class="section-title sep-letters">{{ $mainblock['title'] }}</h1>
                @endif
            </div>
            <div class="flex-block flex-block_padd">
                <div class="flex-block__content">
                	@if(!empty($mainblock['text']))
                    	<div class="quote-text description sep-lines">{{ $mainblock['text'] }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(!empty($mainblock['image']))
        <div class="fw-image-wrapper">
            <div class="fw-image fw-image_halfslide fw">
                <img src="{{ $mainblock['image'] }}">
            </div>
        </div>
    @endif
</section>
