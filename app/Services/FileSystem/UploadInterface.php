<?php

namespace App\Services\FileSystem;


interface UploadInterface
{
    public function upload ($path);

    public function delete ($path);
}
