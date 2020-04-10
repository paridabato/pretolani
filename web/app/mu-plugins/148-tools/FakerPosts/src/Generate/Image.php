<?php

namespace Tools\FakerPosts\Generate;

class Image
{
    public static function getImageUrl(int $width = 1920, int $height = 1080)
    {
        $get_url = 'https://picsum.photos/' . $width . '/' . $height;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $a   = curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        return $url;
    }
}
