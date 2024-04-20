<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\Voiture1Type;
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

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index')]
    public function index(Request $request, VoitureRepository $repository, ModeleRepository $repositorymodel, PaginatorInterface $paginator): Response
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

        $admin = true;

        return $this->render('voiture/index.html.twig', [
            'admin'=> $admin,
            'pagination' => $pagination,
            'voiture'=> $voitures,
            'modele'=> $modeles,
            'form' => $form->createView(),
            'search'=> $voituresearch
        ]);
    }

    #[Route('/new', name: 'app_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(Voiture1Type::class, $voiture);
        $form->handleRequest($request);
        $showSpan = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voiture);
            $entityManager->flush();
            $showSpan = true;

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
            'message' => true,
            'showSpan' => $showSpan
        ]);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('admin/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Voiture1Type::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
