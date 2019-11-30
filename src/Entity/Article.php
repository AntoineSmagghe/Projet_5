<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255)
     */
    private $format;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $api_data;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Img", mappedBy="idArticles", cascade={"persist"})
     */
    private $imgs;

    /**
     * Assert\All({
     *      @Assert\Image(mimeTypes="image/")
     * })
     */
    private $imgsFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->created_at = new DateTime();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->date_event;
    }

    public function setDateEvent(?\DateTimeInterface $date_event): self
    {
        $this->date_event = $date_event;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;
        
        return $this;
    }

    public function getApiData(): ?string
    {
        return $this->api_data;
    }

    public function setApiData(?string $api_data): self
    {
        $this->api_data = $api_data;

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

    /**
     * @return Collection|Img[]|null
     */
    public function getImgs()
    {
        return $this->imgs;
    }

    public function addImg(Img $img): self
    {
        if (!$this->imgs->contains($img)) {
            $this->imgs[] = $img;
            $img->addIdArticle($this);
        }

        return $this;
    }

    public function removeImg(Img $img): self
    {
        if ($this->imgs->contains($img)) {
            $this->imgs->removeElement($img);
            $img->removeIdArticle($this);
        }
        return $this;
    }

    /*
    public function getWebPath()
    {
        $arrayWebPath = array();
        foreach ($this->getImgs() as $img){
            array_push($arrayWebPath, '/upload/pictures/' . $img->getName());
        }
        return $arrayWebPath;
    }
    */

    /**
    * @return mixed
    */
    public function getImgsFile()
    {
        return $this->imgsFile;
    }
    
    /**
     * @param mixed $imgsFile
     * @return Article
     */
    public function setImgsFile($images): self
    {
        foreach($images as $image)
        {
            $img = new Img();
            $img->setImgData($image);
            $this->addImg($img);
        }
        //$this->imgsFile = $images;
        return $this;
    }
    
    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}