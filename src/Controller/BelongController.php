<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BelongController extends AbstractController
{
    /**
     * @Route("/belong", name="belong")
     */
    public function index()
    {
        return $this->render('belong/index.html.twig', [
            'controller_name' => 'BelongController',
        ]);
    }
}
