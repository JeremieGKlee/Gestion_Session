<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SessionType;

class SessionController extends AbstractController
{
    /**
     * @var SessionRepository
     */
    private $repository;
    
    public function __construct(SessionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/session", name="session.index")
     */
    public function index(): Response
    {
        $sessions = $this->repository->findAll();


        return $this->render('session/index.html.twig', compact('sessions'));
    }
    
    /**
     * @Route("/session/{slug}-{id}", name="session.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Session $session, string $slug): Response
    {
        if ($session->getSlug() !== $slug)
        {
            return $this ->redirectToRoute('session.show',
            [
                'id' => $session->getId(),
                'slug' => $session->getSlug()
            ],301);
        }
        return $this-> render('session/show.html.twig',
            [
                'session' => $session,
                'current menu'=> 'sessions'
            ]);

    }

     /**
     * @Route("/session/create", name="session.new")
     */
    public function new(Request $request): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($session);
            $this->em->flush();
            $this->addFlash('success', 'Session créée avec succès');
            return $this->redirectToRoute('session.index');
        }
        return $this->render('session/new.html.twig',
        [
            'session' => $session,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/session/edit/{id}", name="session.edit", methods="GET|POST")
     * @param Session $session
     * @param Session $request
     */
    public function edit(Session $session, Request $request): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Session modifiée avec succès');
            return $this->redirectToRoute('session.index');
        }

        return $this->render('session/edit.html.twig',
        [
            'session' => $session,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/session/delete/{id}", name="session.delete", methods="DELETE")
     * @param session $session
     */
    public function delete(Session $session, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $session->getId(), $request->get('_token')))
        {
            $this->em->remove($session);
            $this->em->flush();
            $this->addFlash('success', 'Session supprimée avec succès');
        }
        
        return $this->redirectToRoute('session.index');
    }
}
