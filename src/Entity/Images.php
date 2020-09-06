<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
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
    private $name_img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path_img;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProprieteBien", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ProprieteBien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameImg(): ?string
    {
        return $this->name_img;
    }

    public function setNameImg(string $name_img): self
    {
        $this->name_img = $name_img;

        return $this;
    }

    public function getPathImg(): ?string
    {
        return $this->path_img;
    }

    public function setPathImg(string $path_img): self
    {
        $this->path_img = $path_img;

        return $this;
    }

    public function getProprieteBien(): ?ProprieteBien
    {
        return $this->ProprieteBien;
    }

    public function setProprieteBien(?ProprieteBien $ProprieteBien): self
    {
        $this->ProprieteBien = $ProprieteBien;

        return $this;
    }
}
