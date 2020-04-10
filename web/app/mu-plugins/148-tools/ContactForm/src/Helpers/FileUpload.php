<?php

namespace Tools\ContactForm\Helpers;

class FileUpload
{
    private $dirPath;

    public function __construct($path)
    {
        $this->dirPath = $path;
        $this->handlePath($this->dirPath);
    }

    private function handlePath($path): void
    {
        if (\file_exists($path)) {
            return;
        }

        mkdir($path, 0755, true);
    }

    public function upload($file, $hash = "")
    {
        $hash = !empty($hash) ? "_$hash" : "";
        $path_info = pathinfo($file['name']);

        $filename = sprintf('%s%s', sanitize_title($path_info['filename']), $hash);
        $ext = $path_info['extension'];
        $name = sprintf('%s.%s', $filename, $ext);

        return move_uploaded_file($file['tmp_name'], $this->dirPath . '/' . $name);
    }
}
