<?php

namespace App\Entity\Lokr;

use DateTimeInterface;

trait Timestamp
{
    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
    */
    private \DateTimeInterface $createdAt;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $updateAt;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }
}