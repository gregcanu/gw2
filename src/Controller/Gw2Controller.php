<?php

// src/Controller/Gw2Controller.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\Gw2Repository;

class Gw2Controller extends AbstractController {

    /**
     * @Route("gw2/items", name="items_show")
     * Affiche la liste des items
     */
    public function getItems() {
        $gw2 = new Gw2Repository();
        $items_id = $gw2->getItemsId();
        $items = [];
        foreach($items_id as $id) {
            $items[$id]["item"] = $gw2->getItem($id);
            $items[$id]["listing"] = $gw2->getListingWithPriceFilter($id);
        }

        return $this->render('gw2/items.html.twig', ['items' => $items]);
    }
    
    /**
     * @Route("gw2/item/{id}", name="item_show")
     * Récupère les informations d'un item
     * id: id de l'item
     */
    public function getItem($id) {
        $gw2 = new Gw2Repository();
        $item = $gw2->getItem($id);
        var_dump($item); die();
    }
    
    /**
     * @Route("gw2/item/listing/{id}", name="item_listing")
     * Récupère les prix d'achat et de vente d'un item
     * id: id de l'item
     */
    public function getItemListing($id) {
        $gw2 = new Gw2Repository();
        $item = $gw2->getListing($id);
        var_dump($item); die();
    }
    
    /**
     * @Route("gw2/test/{id}", name="gw2_test")
     * Permet de tester du code
     * id: id de l'item
     */
    public function test($id) {
        $gw2 = new Gw2Repository();
        $item = $gw2->getListingWithPriceFilter($id);
        var_dump($item); die();
    }
    
}
