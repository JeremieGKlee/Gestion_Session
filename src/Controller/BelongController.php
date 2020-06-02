<?php

namespace App\Controller;

use App\Entity\Belong;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BelongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BelongType;

class BelongController extends AbstractController
{
    /**
     * @var belongRepository
     */
    private $repository;
    
    public function __construct(BelongRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/belong", name="belong.index")
     */
    public function index(): Response
    {
        $belongs = $this->repository->findAll();


        return $this->render('belong/index.html.twig', compact('belongs'));
    }
    
    /**
     * @Route("/belong/{slug}-{id}", name="belong.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Belong $belong, string $slug): Response
    {
        if ($belong->getSlug() !== $slug)
        {
            return $this ->redirectToRoute('belong.show',
            [
                'id' => $belong->getId(),
                'slug' => $belong->getSlug()
            ],301);
        }
        return $this-> render('belong/show.html.twig',
            [
                'belong' => $belong,
                'current menu'=> 'belongs'
            ]);

    }

     /**
     * @Route("/belong/create", name="belong.new")
     */
    public function new(Request $request): Response
    {
        $belong = new Belong();
        $form = $this->createForm(BelongType::class, $belong);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($belong);
            $this->em->flush();
            $this->addFlash('success', 'Programme créé avec succès');
            return $this->redirectToRoute('belong.index');
        }
        return $this->render('belong/new.html.twig',
        [
            'belong' => $belong,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/belong/edit/{id}", name="belong.edit", methods="GET|POST")
     * @param belong $belong
     * @param belong $request
     */
    public function edit(Belong $belong, Request $request): Response
    {
        $form = $this->createForm(BelongType::class, $belong);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Programme modifié avec succès');
            return $this->redirectToRoute('belong.index');
        }

        return $this->render('belong/edit.html.twig',
        [
            'belong' => $belong,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/belong/delete/{id}", name="belong.delete", methods="DELETE")
     * @param belong $belong
     */
    public function delete(Belong $belong, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $belong->getId(), $request->get('_token')))
        {
            $this->em->remove($belong);
            $this->em->flush();
            $this->addFlash('success', 'Belong supprimée avec succès');
        }
        
        return $this->redirectToRoute('belong.index');
    }
}
