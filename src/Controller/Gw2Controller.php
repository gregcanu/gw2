<?php

// src/Controller/Gw2Controller.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\Gw2Repository;
use App\Entity\Item;
use App\Repository\ItemRepository;

class Gw2Controller extends AbstractController {

    /**
     * @Route("gw2/items", name="items_show")
     * Affiche la liste des items
     */
    public function getItems(ItemRepository $itemRepository) {
        $gw2 = new Gw2Repository();
        $items_info = $itemRepository->findAllItems();
        $items = [];
        foreach($items_info as $item) {
            $item['price'] = $gw2->getPriceItem($item['api_id']);
            $item['price_to_sell'] = $gw2->convertPrice($item['price_to_sell']);
            $items[] = $item;
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
     * @Route("gw2/item/price/{id}", name="item_price")
     * Récupère le premier prix d'achat et de vente d'un item
     * id: id de l'item
     */
    public function getItemPrice($id) {
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
    
    /**
     * @Route("/gw2/creer-item", name="create_item")
     */
    public function createItem(ValidatorInterface $validator): Response {
       // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $item = new Item();
        $item->setName('Stabilizing Matrix');
        $item->setImage('image');
        $item->setApiId(73248);
        $item->setPriceToSell(3200);

        $errors = $validator->validate($item);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($item);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$item->getId()); 
    }
    
}
