<?php
namespace App\Controller\Ajax;

use App\Repository\MatriceEvaluationRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AjaxPosteController extends  AbstractController
{
    private EntityManagerInterface $manager;
    private NiveauEtudeRepository $niveauEtudeRepository;
    private PosteRepository $posteRepository;
    private MatriceEvaluationRepository $matriceEvaluationRepository;


    public function __construct(EntityManagerInterface $manager, NiveauEtudeRepository $niveauEtudeRepository, PosteRepository $posteRepository, MatriceEvaluationRepository $matriceEvaluationRepository)
    {
        $this->manager = $manager;
        $this->niveauEtudeRepository = $niveauEtudeRepository;
        $this->posteRepository = $posteRepository;
        $this->matriceEvaluationRepository = $matriceEvaluationRepository;
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

    #[Route('/verifiedMatrice', name: 'verified_matrice', options: ['expose' => true])]
    public function verifiedMatrice(Request $request): JsonResponse
    {
        $poste = $this->posteRepository->findOneBy(['code' => $request->request->get('poste'), 'deleted' => false]);
        $matriceEvaluation = $this->matriceEvaluationRepository->findOneBy(['deleted' => false, 'poste' => $poste]);
        $find = false;
        if($matriceEvaluation){
            $find = true;
        }
        $result = [
            'find' => $find
        ];
        $status = 200;

        return  new JsonResponse($result, $status);
    }
}