<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmInformations extends Model
{
    //

    protected $table = 'firm_informations';
    protected $fillable = ['logo', 'name', 'city', 'town', 'whatsapp', 'phone', 'lat', 'lang', 'area', 'capacity', 'productionTypes', 'market', 'about', 'address', 'firm_id', 'storeAmount', 'storeArea', 'productTypes', 'partners'];
}


