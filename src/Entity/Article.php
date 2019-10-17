<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "S'il te plait, rentre au moins {{ limit }} caractères."
     * )
     */
    private $title;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_event;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $format;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $api_data;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Url
     */
    private $id_admin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDateEvent(): \DateTimeInterface
    {
        return $this->date_event;
    }

    public function setDateEvent(?\DateTimeInterface $date_event): self
    {
        $this->date_event = $date_event;

        return $this;
    }

    public function getIdImg(): int
    {
        return $this->id_img;
    }

    public function setIdImg(int $id_img): self
    {
        $this->id_img = $id_img;

        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getApiData(): string
    {
        return $this->api_data;
    }

    public function setApiData(?string $api_data): self
    {
        $this->api_data = $api_data;

        return $this;
    }

    public function getIdAdmin(): int
    {
        return $this->id_admin;
    }

    public function setIdAdmin(int $id_admin): self
    {
        $this->id_admin = $id_admin;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}