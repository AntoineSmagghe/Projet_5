<?php
namespace App\Service;

use App\Repository\ImgRepository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Uploader
{
    private $uploadDirectory;

    public function __construct($uploadDirectory, ImgRepository $imgRepository)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->imgRepository = $imgRepository;
    }

    public function upload(UploadedFile $file) : string
    {
        // Si le filesize($file) n'est plus le même que le nombre retrouvé dans la BD
        // Alors on renvoie l'erreur > Image déjà téléchargée l'ami!

        $fileSize = filesize($file);
        
        /*if ($this->tchekExistingFile($fileSize) === false){*/
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalName);
            $uniqueName = $safeName . "-" . $fileSize . "." . $file->guessExtension();

            //uniqid()

            
            try {
                $file->move($this->getTargetDirectory(), $uniqueName);
            } catch (FileException $e) {
                // --> Créer une nouvelle exception 
                dump($e);
            }

            return $uniqueName;
        /*}*/
        return false;
    }

    private function tchekExistingFile($fileSize): bool
    {
        $find = new Finder();
        $fk = $find->files()->contains('*- ' . $fileSize . '.*');
        dump($fk);
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