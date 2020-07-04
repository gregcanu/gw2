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
//        var_dump($prices);die();
        $item_prices = [];
        // Convertis le premier prix d'achat et de vente en gold, silver et copper
        $buy = $prices['buys']['unit_price'];
        $item_prices['buy']['gold'] = floor($buy/10000);
        $item_prices['buy']['silver'] = substr(floor($buy/100), -2);
        $item_prices['buy']['copper'] = substr($buy, -2);
        
        $sell = $prices['sells']['unit_price'];
        $item_prices['sell']['gold'] = floor($sell/10000);
        $item_prices['sell']['silver'] = substr(floor($sell/100), -2);;
        $item_prices['sell']['copper'] = substr($sell, -2);
        
        return $item_prices;
    }
}
