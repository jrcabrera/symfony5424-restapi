<?php

namespace App\Controller;

use App\Service\TinyUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api/v1", name="api_test")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/short-urls", name="app_main", methods={"POST"})
     */
    public function index(Request $request, TinyUrl $objTinyUrl): JsonResponse
    {
        $params = json_decode($request->getContent(), true);
        $response = [];

        if (
            !(isset($params['url']))
        ) {
            $response = [
                'message' => 'Url tag is required'
            ];
        } else {
            $requestTiny = array(
                'url' => $params['url']
            );
            $responseTinyUrl = $objTinyUrl->send('create', $requestTiny);

            $response = [
                'url' => $responseTinyUrl['data']['tiny_url'],
            ];
        }

        return $this->json($response);
    }
}
