<?php

// src/Controller/Apigw2Controller.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use App\Repository\Gw2Repository;

class Apigw2Controller extends AbstractController {

    /**
     * @Route("/item/{id}", name="item_show")
     */
    public function getItem($id) {
        $gw2 = new Gw2Repository();
        $item = $gw2->getItem($id);
        var_dump($item); die();
    }
    
    /**
     * @Route("/item/listing/{id}", name="item_listing")
     */
    public function getItemListing($id) {
        $gw2 = new Gw2Repository();
        $item = $gw2->getListing($id);
        var_dump($item); die();
    }
    
}
