<?php

namespace App\Repository;

use Symfony\Component\HttpClient\HttpClient;

class Gw2Repository {
    
    const API_BASE_URL = 'https://api.guildwars2.com/v2/';
    const API_ITEM = 'items?id=';
    const API_LISTING = 'commerce/listings/';
    const API_PRICE = 'commerce/prices/';
    
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
     * Effectue une requête pour interroger l'API GW2
     */
    private function request($id, $type) {
        switch($type) {
            case 'item':
                $request = Gw2Repository::API_ITEM;
                break;
            case 'listing':
                $request = Gw2Repository::API_LISTING;
                break;
            case 'price':
                $request = Gw2Repository::API_PRICE;
                break;
            default:
                echo "Erreur, type de requête non spécifié";
                break;
        }
        
        $client = HttpClient::create();
        $response = $client->request('GET', Gw2Repository::API_BASE_URL.$request.$id);
        
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
}
