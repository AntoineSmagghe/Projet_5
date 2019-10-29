<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImgRepository")
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
     * @ORM\Column(type="datetime")
     */
    private $uploaded_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Article", inversedBy="imgs")
     */
    private $idArticles;

    public function __construct()
    {
        $this->uploaded_at = new DateTime();
        $this->idArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
