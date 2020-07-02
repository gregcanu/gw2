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
     * Récupère les prix d'achat et de vente d'un item selon son id
     * id: id de l'item
     */
    public function getListing($id) {
        return $this->request($id, 'listing');
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
     *  Renvoie le premier prix d'achat et de vente d'un item
     */
    public function getListingWithPriceFilter($id) {
        $listing = $this->request($id, 'listing');
        $prices = [];
        
        // Convertis le premier prix d'achat et de vente en gold, silver et copper
        $buy = $listing['buys'][0]['unit_price'];
        $prices['buy']['gold'] = floor($buy/10000);
        $prices['buy']['silver'] = substr(floor($buy/100), -2);
        $prices['buy']['copper'] = substr($buy, -2);
        
        $sell = $listing['sells'][0]['unit_price'];
        $prices['sell']['gold'] = floor($sell/10000);
        $prices['sell']['silver'] = substr(floor($sell/100), -2);;
        $prices['sell']['copper'] = substr($sell, -2);
        
        return $prices;
    }
}
