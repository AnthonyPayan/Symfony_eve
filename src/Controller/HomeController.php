<?php

namespace App\Controller;

use App\Entity\Alliance;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $alliances = $em->getRepository(Alliance::class)->findAll();

        return $this->render('home/index.html.twig', [
            'alliances' => $alliances
        ]);
    }

    /**
     * @Route("/alliance/{id}/corporations", name="alliance_corporation")
     */
    public function corporations(EntityManagerInterface $em, ApiService $apiService, $id): Response
    {
        $alliance =  $em->getRepository(Alliance::class)->findOneById($id);

        if ($alliance === null) {
            throw new NotFoundHttpException();
        }

        $corporations = $apiService->getAllianceCorporations($alliance->getAllianceId());

        dump($alliance);
        dump($corporations);
        die('end');

        return $this->render('home/index.html.twig', [
            'alliances' => $alliances
        ]);
    }
}
