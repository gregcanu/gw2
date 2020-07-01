<?php

namespace App\Repository;

use App\Entity\Gw2;
use Symfony\Component\HttpClient\HttpClient;

class Gw2Repository {
    
    public function getItem($id) {
        return $this->request($id, 'item');
    }
    
    public function getListing($id) {
        return $this->request($id, 'listing');
    }
    
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
}
