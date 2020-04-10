<?php

/**
 * Create img
 *
 * @param $image_id
 * @param $alt
 * @param $attrs
 * @param $lazyload
 */
function img($image_id, $alt, $attrs = array(), $lazyload = true)
{


    $media_version = json_decode(get_post_meta($image_id, 'media_version', true), true);
    $filename = pathinfo($media_version['original']['normal'], PATHINFO_FILENAME);

    $attr = '';
    $attrs['alt'] = !empty($alt) ? $alt : $filename;

    if ($media_version !== null) {
        $source = [];

        foreach ($media_version as $size => $url) {
            if (!in_array($size, ['original', 'blurred'])) {
                $source[] = sprintf('<source media="(max-width: %spx)" %s="%s">', $url['size'], $lazyload ? 'data-srcset' : 'srcset', sprintf('%s, %s 2x', $url['normal']['x1'], $url['normal']['x2']));
                if (isset($url['webp'])) {
                    $source[] = sprintf('<source media="(max-width: %spx)" %s="%s" type="image/webp">', $url['size'], $lazyload ? 'data-srcset' : 'srcset', sprintf('%s, %s 2x', $url['webp']['x1'], $url['webp']['x2']));
                }
            }
        }

        if ($lazyload) {
            $attrs['data-src'] = $media_version['original']['normal'];
            $attrs['src'] = $media_version['blurred'];
        } else {
            $attrs['src'] = $media_version['original']['normal'];
        }

        foreach ($attrs as $k => $v) {
            $attr .= sprintf(' %s="%s" ', $k, trim($v, " "));
        }

        $img = sprintf('<img %s>', $attr);

        return '<picture>' . implode(' ', $source) . ' ' . $img . '</picture>';
    } else {
        if ($lazyload) {
            $attrs['data-src'] =  wp_get_attachment_url($image_id);
        } else {
            $attrs['src'] =  wp_get_attachment_url($image_id);
        }

        foreach ($attrs as $k => $v) {
            $attr .= sprintf(' %s="%s" ', $k, trim($v, " "));
        }

        return sprintf('<img %s>', $attr);
    }
}
