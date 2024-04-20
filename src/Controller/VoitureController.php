<?php

namespace App\Controller;

use App\Entity\RechercherVoiture;
use App\Form\RechercherVoitureType;
use App\Repository\ModeleRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    #[Route('/client/voiture', name: 'app_voiture')]
    public function index(VoitureRepository $repository, ModeleRepository $repositorymodel, PaginatorInterface $paginator, Request $request): Response
    {
        $voitures = $repository->findAll();
        $modeles = $repositorymodel->findAll();

        $pagination = $paginator->paginate($voitures, /* query NOT result */
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
        );
        $recherche = new RechercherVoiture();
        $form = $this->createForm(RechercherVoitureType::class, $recherche);
        $form->handleRequest($request);
        // dd($recherche);
        $voituresearch = $paginator->paginate(
            $repository->findAllWithPagination($recherche),
            $request->query->getInt('page', 1), 6);


        // parameters to template
        return $this->render('voiture/index.html.twig', [
            'pagination' => $pagination,
            'voiture'=> $voitures,
            'modele'=> $modeles,
            'form' => $form->createView(),
            'search'=> $voituresearch,
            'admin' => false
        ]);
    }
}
