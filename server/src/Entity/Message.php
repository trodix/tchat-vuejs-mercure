<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(mercure=true)
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $user;


    public function __construct() {
        $this->setCreatedAt(new \DateTime());
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'body' => $this->getBody(),
            'user' => $this->getUser(),
            'createdAt' => $this->getCreatedAt()
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

        return $this;
    }

    // public function getTchat(): ?Tchat
    // {
    //     return $this->tchat;
    // }

    // public function setTchat(?Tchat $tchat): self
    // {
    //     $this->tchat = $tchat;

    //     return $this;
    // }
}
