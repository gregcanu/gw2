<?php

namespace App\Entity;

use App\Repository\Gw2Repository;

class Gw2 {

    private $api_url = 'https://api.guildwars2.com/v2/';
    private $item = 'items?id=';
    private $listing = 'commerce/listings/';

    public function getApiUrl() {
        return $this->api_url;
    }

    public function getItem() {
        return $this->item;
    }

    public function getListing() {
        return $this->listing;
    }

}
