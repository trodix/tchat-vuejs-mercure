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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TchatController extends AbstractController
{
    /**
     * @Route("/tchat", name="tchat", methods={"OPTIONS", "POST"})
     */
    public function updateTchat(Publisher $publisher, Request $req)
    {
        $jsonEncoder = new JsonEncoder();
        $entityManager = $this->getDoctrine()->getManager();
        $topic = "http://192.168.0.40:8000/tchat";

        $data = json_decode(
            $req->getContent(),
            true
        );
        
        

        if (null === $data || empty($data)) {
            dump($data);
            return new Response("Data request null or empty", 400);
        }

        $body = $data["body"];
        $user = $data["user"];

        $msg = new Message();
        $msg
            ->setBody($body)
            ->setUser($user)
        ;

        $entityManager->persist($msg);
        $entityManager->flush();

        $jsonData = $jsonEncoder->encode($msg->jsonSerialize(), 'json');

        $update = new Update($topic, $jsonData);
        $publisher($update);

        return $this->json(["action" => "published", "data" => $jsonData], 200, [
            'Content-Type', 'application/json'
        ]);
    }
}
