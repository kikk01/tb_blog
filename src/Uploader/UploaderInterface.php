<?php

namespace App\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploaderInterface
{
    /**
     * Undocumented function
     *
     * @param UploadedFile $file
     * @return sting
     */
    public function upload(UploadedFile $file) : string;
}