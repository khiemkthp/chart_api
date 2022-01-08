<?php

namespace App\Controller;

use App\Entity\TempHumi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

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
        $errorValidation = $this->insertValidation($post_data);

        if (empty($errorValidation)) {
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
            $response['result']['data'] = 'Saved new record with id ' . $temphumi->getId();
            return new Response(json_encode($response));
        }

        $response['result']['ret'] = "Error";
        $response['result']['data']['Error_Message'] = $errorValidation[0];
        return new Response(json_encode($response), 400);
    }

    /**
     * @Route("/temp_humi/archive/{id}", name="temphumi_showByID")
     */
    public function showByID(ManagerRegistry $doctrine, int $id): Response
    {
        $temphumi = $doctrine->getRepository(TempHumi::class)->find($id);

        if (!$temphumi) {
            $response['result']['ret'] = "Error";
            $response['result']['data']['Error_Message'] = 'No record found for id ' . $id;
            return new Response(json_encode($response), 404);
        }

        $response['result']['ret'] = "Success";
        $response['result']['data'] = $this->querySuccessData($temphumi);

        return new Response(json_encode($response));
    }

    /**
     * @Route("/temp_humi/archive", name="temphumi_show")
     */
    public function show(ManagerRegistry $doctrine, Request $request): Response
    {
        $get_data = $request->query->all();
        $temphumi = $doctrine->getRepository(TempHumi::class)
            ->getAll($get_data);

        if (!$temphumi) {
            $response['result']['ret'] = "Error";
            $response['result']['data']['Error_Message'] = 'No record found';
            return new Response(json_encode($response), 404);
        }

        $response['result']['ret'] = "Success";
        $response['result']['data'] = $temphumi;

        return new Response(json_encode($response));
    }

    /**
     * get updated / inserted data
     * 
     * @return array
     */
    private function querySuccessData(TempHumi $temphumi)
    {
        $data['id'] = $temphumi->getId();
        $data['temp'] = $temphumi->getTemp();
        $data['humi'] = $temphumi->getHumi();
        $data['user_push'] = $temphumi->getUserPush();
        $data['time_push'] = $temphumi->getTimePush();
        return $data;
    }

    /**
     * validate insert data
     * 
     * @return array
     */
    public function insertValidation(array $post_data)
    {
        $error = array();

        if (
            !isset($post_data['temp']) ||
            !isset($post_data['humi']) ||
            !isset($post_data['user_push'])
        ) {
            array_push($error, "Missing some parameter");
        } elseif ($post_data['humi'] < 0 || $post_data['humi'] > 100) {
            array_push($error, "Some parameters doesn't match the condition");
        } elseif (!$post_data['user_push']) {
            array_push($error, "User not found");
        }

        return $error;
    }
}
