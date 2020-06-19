<?php

// src/Controller/MainController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
      * @Route("/home")
      */
    public function home()
    {
        $message = "Hello";

        return $this->render('home.html.twig', ['message' => $message]);
    }
    
    /**
      * @Route("/cv")
      */
    public function cv()
    {
        return $this->render('cv.html.twig');
    }
}
