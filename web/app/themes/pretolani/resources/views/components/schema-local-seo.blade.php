{{-- Avoid errors --}}
@if (function_exists('get_field'))
  {{-- Display our Schema Local SEO --}}
  @if (!get_field('add_generator_schema', 'option') || get_field('add_generator_schema', 'option') == 'no')
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "{{ !empty(get_field('scheme_organisation_name', 'option')) ? get_field('scheme_organisation_name', 'option') : get_bloginfo('name') }}",
        "legalName": "{{ !empty(get_field('scheme_organisation_legalName', 'option')) ? get_field('scheme_organisation_legalName', 'option') : get_bloginfo('name') }}",
        "description": "{{ !empty(get_field('scheme_organisation_description', 'option')) ? get_field('scheme_organisation_description', 'option') : get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true) }}",
        "url": "{{ !empty(get_field('scheme_organisation_url', 'option')) ? get_field('scheme_organisation_url', 'option') : get_bloginfo('url') }}",
        "logo": "{{ !empty(get_field('scheme_organisation_logo', 'option')) ? get_field('scheme_organisation_logo', 'option') : wp_get_attachment_image_src(get_theme_mod('custom_logo') , 'full')[0] }}",
        @if (!empty(get_field('scheme_organisation_address', 'option'))
        && count(get_field('scheme_organisation_address', 'option')) == 5)
          "address":{
            "@type":"PostalAddress",
            "streetAddress": "{{ get_field('scheme_organisation_address', 'option')['scheme_organisation_streetAddress'] }}",
            "addressLocality": "{{ get_field('scheme_organisation_address', 'option')['scheme_organisation_addressLocality'] }}",
            "addressRegion": "{{ get_field('scheme_organisation_address', 'option')['scheme_organisation_addressRegion'] }}",
            "postalCode": "{{ get_field('scheme_organisation_address', 'option')['scheme_organisation_postalCode'] }}",
            "addressCountry": "{{ get_field('scheme_organisation_address', 'option')['scheme_organisation_addressCountry'] }}"
          },
        @endif
        @if (!empty(get_field('scheme_organisation_telephone', 'option')))
          "contactPoint": [
            {
              "@type":"ContactPoint",
              "contactType":"customer support",
              "telephone": "{{ get_field('scheme_organisation_telephone', 'option') }}"
            }
          ],
        @endif
        @if (!empty(get_field('scheme_organisation_email', 'option')))
          "email": "{{ get_field('scheme_organisation_email', 'option') }}"
        @endif
      }
    </script>
  @else
    {{-- Display Schema Local SEO from Generator --}}
    {!! get_field('scheme_all', 'option') !!}
  @endif
@endif
