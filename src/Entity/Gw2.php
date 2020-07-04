<?php

namespace App\Entity;

class Gw2 {

    private $api_url = 'https://api.guildwars2.com/v2/';
    private $item = 'items?id=';
    private $listing = 'commerce/listings/';
    private $price = 'commerce/prices/';
    private $items_id = [75919,73248,90910,46738,46739,19722,37907,19721];

    public function getApiUrl() {
        return $this->api_url;
    }

    public function getItem() {
        return $this->item;
    }

    public function getListing() {
        return $this->listing;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
   public function getItemsId() {
        return $this->items_id;
    }

}
