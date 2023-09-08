<?php
namespace App\Controller\Ajax;

use App\Repository\NiveauEtudeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AjaxPosteController extends  AbstractController
{
    private EntityManagerInterface $manager;
    private NiveauEtudeRepository $niveauEtudeRepository;


    public function __construct(EntityManagerInterface $manager, NiveauEtudeRepository $niveauEtudeRepository)
    {
        $this->manager = $manager;
        $this->niveauEtudeRepository = $niveauEtudeRepository;
    }

    #[Route('/createFields', name: 'createFields', options: ['expose' => true])]
    public function createFields(Request $request): JsonResponse
    {
        $niveau = $this->niveauEtudeRepository->find($request->get('niveauEtude'));
        $domaine =  false ;
        if($niveau->isDomaine()){
            $domaine = true;
        }
        $result = [
            'domaine' => $domaine,
        ];
        $status = 200;

        return  new JsonResponse($result, $status);
    }
}