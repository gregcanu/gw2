<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Gw2Repository;

/**
 * @Route("/item")
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/", name="item_index", methods={"GET"})
     */
    public function index(ItemRepository $itemRepository): Response
    {
        $gw2 = new Gw2Repository();
        $items_info = $itemRepository->findAllItems();
        $items = [];
        foreach($items_info as $item) {
            $item['price'] = $gw2->getPriceItem($item['api_id']);
            $item['is_sellable'] = $this->isSellable( $item['price']['raw_sell_price'], $item['price_to_sell']);
            $item['price_to_sell'] = $gw2->convertPrice($item['price_to_sell']);
            $items[] = $item;
        }
        // Tri le tableau en remontant les items qu'il faut vendre
        array_multisort(array_column($items, 'is_sellable'), SORT_DESC, $items);
        return $this->render('item/index.html.twig', ['items' => $items]);
    }
    
    /*
     * Compare le prix de vente en commerce d'un item avec le prix à vendre pour savoir si il faut vendre l'item
     * Retourne 1 si je dois vendre l'item (prix commerce >= prix auquel je dois vendre), sinon retourne 0
     */
    private function isSellable($sell_price, $price_to_sell) {
        if($sell_price >= $price_to_sell) {
            return 1;
        }
        return 0;
    }

    /**
     * @Route("/new", name="item_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($item);
            $entityManager->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/new.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_show", methods={"GET"})
     */
    public function show(ItemRepository $itemRepository, Gw2Repository $gw2, $id): Response
    {
        $item = $itemRepository->findItem($id);
        $item['price_to_sell'] = $gw2->convertPrice($item['price_to_sell']);
        $item['price'] = $gw2->getPriceItem($item['api_id']);
        $item['listing'] = $gw2->getListing($item['api_id'], 10);
        $item['info'] = $gw2->getItem($item['api_id']);
        
        return $this->render('item/show.html.twig', [
            'item' => $item,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Item $item): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('item_index');
        }

        return $this->render('item/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="item_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Item $item): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($item);
            $entityManager->flush();
        }

        return $this->redirectToRoute('item_index');
    }
}
