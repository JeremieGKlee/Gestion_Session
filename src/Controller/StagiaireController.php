<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\StagiaireType;

class StagiaireController extends AbstractController
{
    /**
     * @var StagiaireRepository
     */
    private $repository;
    
    public function __construct(StagiaireRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    
    
    /**
     * @Route("/stagiaire", name="stagiaire.index")
     */
    public function index(): Response
    {
        $stagiaires = $this->repository->findAll();


        return $this->render('stagiaire/index.html.twig', compact('stagiaires'));
    }
    
     /**
     * @Route("/stagiaire/create", name="stagiaire.new")
     */
    public function new(Request $request): Response
    {
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($stagiaire);
            $this->em->flush();
            $this->addFlash('success', 'Stagiaire créé avec succès');
            return $this->redirectToRoute('stagiaire.index');
        }
        return $this->render('stagiaire/new.html.twig',
        [
            'stagiaire' => $stagiaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stagiaire/edit/{id}", name="stagiaire.edit", methods="GET|POST")
     * @param Stagiaire $property
     * @param Stagiaire $request
     */
    public function edit(Stagiaire $stagiaire, Request $request): Response
    {
        // $option = new Option();
        // $property -> addOption($option);
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // if($property->getImageFile() instanceof UploadedFile)
            // {
            //     $cacheManager->remove($helper->asset($property, 'imageFile'));
            // }
            $this->em->flush();
            $this->addFlash('success', 'Stagiaire modifié avec succès');
            return $this->redirectToRoute('stagiaire.index');
        }

        return $this->render('stagiaire/edit.html.twig',
        [
            'stagiaire' => $stagiaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stagiaire/delete/{id}", name="stagiaire.delete", methods="DELETE")
     * @param Stagiaire $stagiaire
     */
    public function delete(Stagiaire $stagiaire, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $stagiaire->getId(), $request->get('_token')))
        {
            $this->em->remove($stagiaire);
            $this->em->flush();
            $this->addFlash('success', 'Stagiaire supprimé avec succès');
        }
        
        return $this->redirectToRoute('stagiaire.index');
    }
}
