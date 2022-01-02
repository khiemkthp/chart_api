<?php

namespace App\Controller;

use App\Entity\TempHumi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;

class TempHumiController extends AbstractController
{
    /**
     * @Route("/temp_humi", name="temp_humi")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TempHumiController.php',
        ]);
    }

    /**
     * @Route("/temp_humi/create", name="insertData")
     */
    public function insertData(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($request->getMethod() != 'POST') {
            return new Response("Access denied", 403);
        }
        
        $post_data = json_decode($request->getContent(), true);
        $error = array();
        if (!isset($post_data['temp']) ||
            !isset($post_data['humi']) ||
            !isset($post_data['user_push'])
        ) {
            array_push($error, "Missing some parameter");
        }

        if (empty($error)) {
            $entityManager = $doctrine->getManager();
            $temphumi = new TempHumi();

            $temphumi->setTemp($post_data['temp']);
            $temphumi->setHumi($post_data['humi']);
            $temphumi->setUserPush($post_data['user_push']);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $temphumi->setTimePush(new \DateTime());

            $entityManager->persist($temphumi);
            $entityManager->flush();

            $response['result']['ret'] = "Success";
            $response['result']['data'] = 'Saved new product with id '.$temphumi->getId();
            return new Response(json_encode($response));
        }

        $response['result']['ret'] = "Error";
        $response['result']['data'] = $error[0];
        return new Response(json_encode($response));
    }

    
}
