<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImgRepository")
 * @Vich\Uploadable()
 */
class Img
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")    
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $name;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="name")
     * @var File
     */
    private $imgData;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $uploaded_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="imgs")
     */
    private $idArticles;

    public function __construct()
    {
        $this->idArticles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var File|null
     */
    public function setImgData(File $image = null): self
    {
        $this->imgData = $image;
        if ($image){
            $this->uploaded_at = new DateTime('now');
        }
        return $this;
    }

    public function getImgData(): ?File
    {
        return $this->imgData;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUploadedAt(): ?DateTime
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(\DateTimeInterface $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getIdArticles(): Collection
    {
        return $this->idArticles;
    }

    public function addIdArticle(Article $idArticle): self
    {
        if (!$this->idArticles->contains($idArticle)) {
            $this->idArticles[] = $idArticle;
        }

        return $this;
    }

    public function removeIdArticle(Article $idArticle): self
    {
        if ($this->idArticles->contains($idArticle)) {
            $this->idArticles->removeElement($idArticle);
        }

        return $this;
    }
}
