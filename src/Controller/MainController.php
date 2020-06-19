<?php

// src/Controller/MainController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
      * @Route("/home", name="home")
      */
    public function home()
    {
        $message = "Hello";

        return $this->render('main/home.html.twig', ['message' => $message]);
    }
    
    /**
      * @Route("/cv", name="cv")
      */
    public function cv()
    {
        return $this->render('main/cv.html.twig');
    }
}
