<?php

namespace App\Entity;

use DateTime;
use App\Entity\Article;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

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
     */
    private $name;

    /**
     * @Assert\Image(
     *      mimeTypes="image/"
     * )
     * @Vich\UploadableField(mapping="images", fileNameProperty="name")
     */
    private $imgData;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $uploaded_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="imgs")
     */
    private $article;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->uploaded_at = new DateTime('now');
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
     * @return null|File
     */
    public function getImgData()
    {
        return $this->imgData;
    }

    /**
     * @param null|File $imgData
     * @return self
     */
    public function setImgData(File $image = null): self
    {
        $this->imgData = $image;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
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
     * @return Collection|Article
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    /**
     * @param Collection|Article
     */    
    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
        }

        return $this;
    }
}