<?php

namespace App\Controller;

use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TchatController extends AbstractController
{
    /**
     * @Route("/tchat", name="tchat", methods={"POST"})
     */
    public function updateTchat(Publisher $publisher)
    {
        $update = new Update("http://localhost:8000/tchat", "[]");
        $publisher($update);
        return $this->json(["/tchat" => "published"], 200);
    }
}
