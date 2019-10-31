<?php
namespace App\Service;

use Symfony\Component\Finder\Finder;
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
        // Si le filesize($file) est plus le même que le nombre retrouvé dans la BD
        //
        // Alors on renvoie l'erreur > Image déjà téléchargée l'ami!

        $fileSize = filesize($file);

        if (!$this->tchekExistingFile($fileSize)){
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalName);
            $uniqueName = $safeName . "-" . $fileSize . "." . $file->guessExtension();
            
            //uniqid()
            
            try {
                $file->move($this->getTargetDirectory(), $uniqueName);
            } catch (FileException $e) {
                // --> créer une nouvelle exception 
                dump($e);
            }

            return $uniqueName;
        }
    }

    private function tchekExistingFile($fileSize): bool
    {
        $find = new Finder();
        if ($find->files()->name('*- ' . $fileSize . '.*')){
            return true;
        }
        return false;
    }   

    public function getTargetDirectory() : string
    {
        return $this->uploadDirectory;
    }
}