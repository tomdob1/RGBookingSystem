<?php

namespace App\Entity;

use App\Repository\BookTblRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookTblRepository::class)
 */
class BookTbl
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
    private $employeeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $officeId;

    /**
     * @ORM\Column(type="integer")
     */
    private $seatNo;

    /**
     * @ORM\Column(type="string")
     */
    private $bookingTime;

    /**
     * @ORM\Column(type="string", length="100")
     */
    private $bookingDate;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?int
    {
        return $this->employeeId;
    }

    public function setEmployeeId(int $employeeId): self
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    public function getOfficeId(): ?int
    {
        return $this->officeId;
    }

    public function setOfficeId(int $officeId): self
    {
        $this->officeId = $officeId;

        return $this;
    }

    public function getSeatNo(): ?int
    {
        return $this->seatNo;
    }

    public function setSeatNo(int $seatNo): self
    {
        $this->seatNo = $seatNo;

        return $this;
    }

    public function getBookingTime(): string
    {
        return $this->bookingTime;
    }

    public function setBookingTime(string $bookingTime): self
    {
        $this->bookingTime = $bookingTime;

        return $this;
    }

    public function getBookingDate(): string
    {
        return $this->bookingDate;
    }

    public function setBookingDate($bookingDate): self
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }
}
