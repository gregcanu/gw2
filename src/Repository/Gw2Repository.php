<?php

namespace App\Repository;

use App\Entity\Gw2;
use Symfony\Component\HttpClient\HttpClient;

class Gw2Repository {
    
    /*
     *Récupère les informations d'un item selon son id
    * id: id de l'item
    */
    public function getItem($id) {
        return $this->request($id, 'item');
    }
    
    /* 
     * Récupère tous les prix d'achat et de vente d'un item selon son id
     * id: id de l'item
     */
    public function getListing($id) {
        return $this->request($id, 'listing');
    }
    
    /* 
     * Récupère les premier prix d'achat et de vente d'un item selon son id
     * id: id de l'item
     */
    public function getPrice($id) {
        return $this->request($id, 'price');
    }
    
    /*
     * Récupère la liste des id des items qui m'intéresse
     */
    public function getItemsId() {
        $gw2 = new Gw2();
        return $gw2->getItemsId();
    }
    
    /*
     * Effectue une requête HTTP pour interroger l'API GW2
     */
    private function request($id, $type) {
        $gw2 = new Gw2();
        $url = $gw2->getApiUrl();
        
        switch($type) {
            case 'item':
                $request = $gw2->getItem();
                break;
            case 'listing':
                $request = $gw2->getListing();
                break;
            case 'price':
                $request = $gw2->getPrice();
                break;
            default:
                echo "Erreur, type de requête non spécifié";
                break;
        }
        
        $client = HttpClient::create();
        $response = $client->request('GET', $url.$request.$id);
        
        if($response->getStatusCode() != 200) {
            return "Objet introuvable";
        }
        
        return $response->toArray();
    }
    
    /*
     *  Renvoie le premier prix d'achat (le plus élevé) et de vente (le plus bas) d'un item
     */
    public function getPriceItem($id) {
        $prices= $this->request($id, 'price');
        $item_prices = [];
        
        // Prix en copper
        $buy = $prices['buys']['unit_price'];
        $sell = $prices['sells']['unit_price'];
        
        // Prix convertis en gold, silver, copper
        $item_prices['buy'] = $this->convertPrice($buy);
        $item_prices['sell'] = $this->convertPrice($sell);
        
        return $item_prices;
    }
    
    /*
     * Convertis le prix d'un item : copper => gold, silver, copper
     * Exemple : 45278copper = 4gold 52silver 78copper
     */
    public function convertPrice($price) {
        $item_price = [];
        $item_price['gold'] = floor($price/10000);
        $item_price['silver'] = substr(floor($price/100), -2);
        $item_price['copper'] = substr($price, -2);
        
        return $item_price;
    }
    
    /*
     * Renvoie le prix auquel je dois vendre chaque item
     * Le prix est entré manuellement ici selon les variations que je vois sur le commerce
     * A terme il faudrait créé une fonctionnalité permettant de changer ces valeurs via une IHM
     */
    public function getItemPriceToSell($id) {
        $gw2 = new Gw2();
        $items_prices = $gw2->getItemsPriceToSell();
        
        return $this->convertPrice($items_prices[$id]);
    }
}
