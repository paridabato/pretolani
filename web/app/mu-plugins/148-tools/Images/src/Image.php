<?php

namespace Tools\Images;

class Image
{
    private $path;
    private $image;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->setImage($this->path);
    }

    public function __destruct()
    {
        $this->destroy();
    }

    public function setImage(string $path)
    {
        try {
            $this->image = new \Imagick($path);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function optimize()
    {
        if (is_null($this->image)) {
            return;
        }

        if ($this->image->getImageFormat() == 'GIF') {
            $image = $this->image->coalesceImages();
            # Save new image
            foreach ($image as $frame) {
                # Remove ICC profile (prefer presuming sRGB) and meta data.
                $frame->stripImage();
                # Equivalent to quality 60 with 'Save for Web' in Photoshop.
                $frame->unsharpMaskImage(0.25, 0.08, 8.3, 0.045);
            }
            $this->image = $image->deconstructImages();
            $this->image->writeImages($this->path, true);
        } else {
            # Save new image
            # Remove ICC profile (prefer presuming sRGB) and meta data.
            $this->image->stripImage();
            # Equivalent to quality 60 with 'Save for Web' in Photoshop.
            $this->image->unsharpMaskImage(0.25, 0.08, 8.3, 0.045);
            $this->image->writeImage($this->path);
            # Save version Webp
            $this->image->setImageCompressionQuality(50);
            $this->image->setOption('webp:lossless', 'true');
            $this->image->writeImage(preg_replace('/\.[^.]+$/', '.webp', $this->path));
        }
    }

    public function generate(array $breakpoints)
    {
        if (is_null($this->image)) {
            return;
        }

        # Check if is GIF
        if ($this->image->getImageFormat() == 'GIF') {
            # Normal Version
            foreach ($breakpoints as $size) {
                if ($this->image->getImageWidth() >= $size) {
                    # Version x2
                    $this->resize($size * 2, false, true);
                    # Version x1
                    $this->resize($size, false, true);
                }
            }
        } else {
            # Normal Version
            foreach ($breakpoints as $size) {
                if ($this->image->getImageWidth() >= $size) {
                    # Version x2
                    $this->resize($size * 2);
                    # Version x1
                    $this->resize($size);
                }
            }
            # Webp Version
            foreach ($breakpoints as $size) {
                if ($this->image->getImageWidth() >= $size) {
                    # Version x2
                    $this->resize($size * 2, true);
                    # Version x1
                    $this->resize($size, true);
                }
            }
        }
    }

    public function generateMeta(int $id, array $breakpoints)
    {
        if (is_null($this->image)) {
            return;
        }

        $image = clone $this->image;
        $url = wp_get_attachment_url($id);

        $media_version = [];

        foreach ($breakpoints as $size) {
            if ($image->getImageWidth() >= $size) {
                $name = $url;
                $media_version['w'.$size]['size'] = $size;
                $media_version['w'.$size]['normal']['1x'] = preg_replace('/\.(?=[^.]+$)/', sprintf('@%sw.', $size), $name);
                $media_version['w'.$size]['normal']['2x'] = preg_replace('/\.(?=[^.]+$)/', sprintf('@%sw.', $size * 2), $name);
                if ($image->getImageFormat() != 'GIF') {
                    $name = preg_replace('/\.[^.]+$/', '.webp', $name);
                    $media_version['w'.$size]['webp']['1x'] = preg_replace('/\.(?=[^.]+$)/', sprintf('@%sw.', $size), $name);
                    $media_version['w'.$size]['webp']['2x'] = preg_replace('/\.(?=[^.]+$)/', sprintf('@%sw.', $size * 2), $name);
                }
            }
        }

        $image->resizeImage(4, null, \Imagick::FILTER_LANCZOS, 1);
        $media_version['blurred'] = sprintf('data:%s;base64,%s', $image->getImageFormat(), base64_encode($image->getimageblob()));
        $media_version['original']['normal'] = $url;
        if ($image->getImageFormat() != 'GIF') {
            $media_version['original']['webp'] = preg_replace('/\.[^.]+$/', '.webp', $url);
        }

        $image->destroy();

        update_post_meta($id, 'media_version', json_encode($media_version));
    }

    public function webp()
    {
        $image = clone $this->image;
        $image->setImageCompressionQuality(50);
        $image->setOption('webp:lossless', 'true');
        $image_name = preg_replace('/\.[^.]+$/', '.webp', $this->path);

        return [
            'image' => $image,
            'name'  => $image_name
        ];
    }

    public function destroy()
    {
        if (!is_null($this->image)) {
            $this->image->destroy();
        }
    }

    private function resize(int $size, bool $webp = false, bool $gif = false)
    {
        if ($webp) {
            $webp   = $this->webp();
            $image  = $webp['image'];
            $name   =  $webp['name'];
        } else {
            $image  = clone $this->image;
            $name   = $this->path;
        }

        if ($gif) { # Gif Version
            $image = $image->coalesceImages();
            foreach ($image as $frame) {
                $frame->resizeImage($size, null, \Imagick::FILTER_LANCZOS, 1);
            }
            $image = $image->deconstructImages();
            $image->writeImages(preg_replace('/\.(?=[^.]+$)/', sprintf('@%sw.', $size * 2), $name), true);
        } else { # Normal Version
            $image->resizeImage($size, null, \Imagick::FILTER_LANCZOS, 1);
            $image->writeImage(preg_replace('/\.(?=[^.]+$)/', sprintf('@%sw.', $size), $name));
        }

        $image->destroy();
    }
}
