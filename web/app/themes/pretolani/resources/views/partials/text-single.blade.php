@empty($text_single)
    @php $text_single = get_field('text_single', $post->ID); @endphp
@endempty

@if(!empty($text_single['text']) || !empty($text_single['author']))
    <section class="page-section section">
        <div class="section__wrapper wrapper">
            <div class="t-center description">

            	@if(!empty($text_single['text']))
                	<h2 class="sep-lines t-normal title">{!! $text_single['text'] !!}</h2>
                @endif

                @if(!empty($text_single['author']))
                	<p class="sep-lines author-name">{!! $text_single['author'] !!}</p>
                @endif

            </div>
        </div>
    </section>
@endif