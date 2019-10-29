<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Uploader
{
    private $uploadDirectory;

    public function __construct($uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function upload(UploadedFile $file) : string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalName);
        $uniqueName = $safeName . "-" . uniqid() . "." . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $uniqueName);
        } catch (FileException $e) {
            // --> créer une nouvelle exception 
            dump($e);
        }
        
        return $uniqueName;
    }

    public function getTargetDirectory() : string
    {
        return $this->uploadDirectory;
    }
}