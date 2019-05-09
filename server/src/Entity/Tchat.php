<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource(mercure=true)
 * @ORM\Entity(repositoryClass="App\Repository\TchatRepository")
 */
class Tchat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // /**
    //  * @return Collection|Message[]
    //  */
    // public function getMessages(): Collection
    // {
    //     return $this->messages;
    // }

    // public function addMessage(Message $message): self
    // {
    //     if (!$this->messages->contains($message)) {
    //         $this->messages[] = $message;
    //         $message->setTchat($this);
    //     }

    //     return $this;
    // }

    // public function removeMessage(Message $message): self
    // {
    //     if ($this->messages->contains($message)) {
    //         $this->messages->removeElement($message);
    //         // set the owning side to null (unless already changed)
    //         if ($message->getTchat() === $this) {
    //             $message->setTchat(null);
    //         }
    //     }

    //     return $this;
    // }
}
