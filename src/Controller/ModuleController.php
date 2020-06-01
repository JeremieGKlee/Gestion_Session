<?php

namespace App\Controller;

use App\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ModuleType;

class ModuleController extends AbstractController
{
    /**
     * @var ModuleRepository
     */
    private $repository;
    
    public function __construct(ModuleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * @Route("/module", name="module.index")
     */
    public function index(): Response
    {
        $modules = $this->repository->findAll();

        return $this->render('module/index.html.twig', compact('modules'));
    }

    /**
     * @Route("/module/create", name="module.new")
     */
    public function new(Request $request): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($module);
            $this->em->flush();
            $this->addFlash('success', 'Module créé avec succès');
            return $this->redirectToRoute('module.index');
        }
        return $this->render('module/new.html.twig',
        [
            'module' => $module,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/module/edit/{id}", name="module.edit", methods="GET|POST")
     * @param module $property
     * @param module $request
     */
    public function edit(module $module, Request $request): Response
    {
        $form = $this->createForm(ModuleType::class, $module);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Module modifié avec succès');
            return $this->redirectToRoute('module.index');
        }

        return $this->render('module/edit.html.twig',
        [
            'module' => $module,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/module/delete/{id}", name="module.delete", methods="DELETE")
     * @param module $module
     */
    public function delete(module $module, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $module->getId(), $request->get('_token')))
        {
            $this->em->remove($module);
            $this->em->flush();
            $this->addFlash('success', 'Module supprimé avec succès');
        }
        
        return $this->redirectToRoute('module.index');
    }
}
