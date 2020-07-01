<?php

namespace App\Entity;

use App\Repository\Gw2Repository;

class Gw2 {

    private $api_url = 'https://api.guildwars2.com/v2/';
    private $item = 'items?id=';
    private $listing = 'commerce/listings/';
    private $items_id = [90910, 75919, 73248, 46738, 46739, 19722];

    public function getApiUrl() {
        return $this->api_url;
    }

    public function getItem() {
        return $this->item;
    }

    public function getListing() {
        return $this->listing;
    }
    
   public function getItemsId() {
        return $this->items_id;
    }

}
