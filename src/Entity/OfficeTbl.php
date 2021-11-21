<?php

namespace App\Entity;

use App\Repository\OfficeTblRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfficeTblRepository::class)
 */
class OfficeTbl
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $officeSeats;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfficeSeats(): ?int
    {
        return $this->officeSeats;
    }

    public function setOfficeSeats(int $officeSeats): self
    {
        $this->officeSeats = $officeSeats;

        return $this;
    }
}
