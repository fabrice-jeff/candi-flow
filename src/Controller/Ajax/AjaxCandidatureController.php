<?php
namespace App\Controller\Ajax;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AjaxCandidatureController extends  AbstractController
{
    private EntityManagerInterface $manager;


    public function __construct(EntityManagerInterface $manager,)
    {
        $this->manager = $manager;
    }

    #[Route('/parcoursGlobal', name: 'parcoursGlobal', options: ['expose' => true])]
    public function parcoursGlobal(Request $request): JsonResponse
    {
        $dureeCv = $request->request->get('dureeCv');
        $posteCv = $request->request->get('posteCv');
        $organismeCv = $request->request->get('organismeCv');

        $html =  $this->renderView('candidature/parcours_global.html.twig', [
            'duree' =>  $dureeCv,
            'poste' =>  $posteCv,
            'organisme' =>  $organismeCv,
        ]);
        $result = [
            'html'  => $html
        ];
        $status = 200;

        return  new JsonResponse($result, $status);
    }
}