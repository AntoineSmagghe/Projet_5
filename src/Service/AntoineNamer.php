<?php

namespace App\Service;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class AntoineNamer implements NamerInterface
{
    public function name($object, PropertyMapping $mapping) : string
    {
        $input = $mapping->getFile($object);
        $fileSize = filesize($input);
        $originalName = pathinfo($input->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = hash('sha256', transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalName));
        $uniqueName = $safeName . "-" . $fileSize . "." . $input->guessExtension();

        return $uniqueName;
    }
}