<?php

namespace App\Controller;

use App\Entity\Tchat;
use App\Entity\Message;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TchatController extends AbstractController
{
    /**
     * @Route("/tchat", name="tchat", methods={"POST"})
     */
    public function updateTchat(Publisher $publisher, Request $req)
    {
        $jsonEncoder = new JsonEncoder();
        $entityManager = $this->getDoctrine()->getManager();
        
        //$tchat1 = new Tchat();
        $msg = new Message();

        $body = $req->request->get("body");
        $user = $req->request->get("user");

        if (null === $body || null === $user || empty($body) || empty($user)) {
            dump($req->request);
            dump($body);
            dump($user);
            return new Response(400);
        }

        $msg
            //->setTchat($tchat1)
            ->setBody($body)
            ->setUser($user)
        ;
        $entityManager->persist($msg);
        $entityManager->flush();

        $jsonData = $jsonEncoder->encode($msg->jsonSerialize(), 'json');

        $update = new Update("http://127.0.0.1:8000/tchat", $jsonData);
        $publisher($update);

        return $this->json(["action" => "published"], 200);
    }
}
