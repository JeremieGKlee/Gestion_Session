<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategorieType;

class CategorieController extends AbstractController
{
    /**
     * @var CategorieRepository
     */
    private $repository;
    
    public function __construct(CategorieRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/categorie", name="categorie.index")
     */
    public function index()
    {   
        $categories = $this->repository->findAll();

        return $this->render('categorie/index.html.twig', compact('categories'));
    }

     /**
     * @Route("/categorie/create", name="categorie.new")
     */
    public function new(Request $request): Response
    {
        $categorie = new categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie créée avec succès');
            return $this->redirectToRoute('categorie.index');
        }
        return $this->render('categorie/new.html.twig',
        [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categorie/edit/{id}", name="categorie.edit", methods="GET|POST")
     * @param categorie $property
     * @param categorie $request
     */
    public function edit(categorie $categorie, Request $request): Response
    {
        // $option = new Option();
        // $property -> addOption($option);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // if($property->getImageFile() instanceof UploadedFile)
            // {
            //     $cacheManager->remove($helper->asset($property, 'imageFile'));
            // }
            $this->em->flush();
            $this->addFlash('success', 'Catégorie modifiée avec succès');
            return $this->redirectToRoute('categorie.index');
        }

        return $this->render('categorie/edit.html.twig',
        [
            'categorie' => $categorie,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categorie/delete/{id}", name="categorie.delete", methods="DELETE")
     * @param categorie $categorie
     */
    public function delete(categorie $categorie, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->get('_token')))
        {
            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès');
        }
        
        return $this->redirectToRoute('categorie.index');
    }
}
