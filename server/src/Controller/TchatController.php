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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TchatController extends AbstractController
{
    /**
     * @Route("/tchat", name="tchat", methods={"POST"})
     */
    public function updateTchat(Publisher $publisher, Request $req)
    {
        $serializer = new Serializer();
        $entityManager = $this->getDoctrine()->getManager();
        
        //$tchat1 = new Tchat();
        $msg = new Message();

        $body = $req->request->get('body');
        $user = $req->request->get('user');

        if (null === $body || null === $user || empty($body) || empty($user)) {
            dump($req);
            return new Response(400);
        }

        $msg
            //->setTchat($tchat1)
            ->setBody($body)
            ->setUser($user)
        ;
        $entityManager->persist($msg);
        $entityManager->flush();

        $update = new Update("http://192.168.0.40:8000/tchat", $serializer->serialize($msg, 'json'));
        $publisher($update);

        return $this->json(["/tchat" => "published"], 200);
    }
}
