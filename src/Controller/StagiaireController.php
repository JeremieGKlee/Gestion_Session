<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Entity\Session;
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
     * @Route("/stagiaire/{slug}-{id}", name="stagiaire.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Stagiaire $stagiaire, string $slug): Response
    {
        if ($stagiaire->getSlug() !== $slug)
        {
            return $this ->redirectToRoute('stagiaire.show',
            [
                'id' => $stagiaire->getId(),
                'slug' => $stagiaire->getSlug()
            ],301);
        }
        return $this-> render('stagiaire/show.html.twig',
            [
                'stagiaire' => $stagiaire,
                'current menu'=> 'stagiaires'
            ]);

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
            $error = 0;
            foreach($stagiaire->getSessions() as $session)
            {
                if($session->getIsFull())
                {
                    $this->addFlash('error', 'Désolé la session de formation est complète');
                    $error++;
                }
            }
            if($error==0)
            {
            $this->em->persist($stagiaire);
            $this->em->flush();
            $this->addFlash('success', 'Stagiaire créé avec succès');
            return $this->redirectToRoute('stagiaire.index');
            }
        }
        return $this->render('stagiaire/new.html.twig',
        [
            'stagiaire' => $stagiaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stagiaire/edit/{id}", name="stagiaire.edit", methods="GET|POST")
     * @param Stagiaire $stagiaire
     * @param Stagiaire $request
     */
    public function edit(Stagiaire $stagiaire, Request $request): Response
    {
        $sessions = $this->em->getRepository(Session::class)->findAll();
        $sessions_dispo =array_filter($sessions, function($session) use($stagiaire)
        {
            return !$session->getIsFull() || $stagiaire->getSessions()->contains($session);
        });
        $form = $this->createForm(StagiaireType::class, $stagiaire,
    [
        'sessions_dispo' => $sessions_dispo
    ]);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $error = 0;
            foreach($stagiaire->getSessions() as $session)
            {
                if($session->getIsFull() && !$stagiaire->getSessions()->contains($session))
                {
                    $this->addFlash('error', 'Désolé la session de formation est complète');
                    $error++;
                }
            }
            if($error==0)
            {
                $this->em->flush();
                $this->addFlash('success', 'Stagiaire modifié avec succès');
                return $this->redirectToRoute('stagiaire.index');
            }
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
