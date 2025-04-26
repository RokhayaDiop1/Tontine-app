<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    protected $fillable = [
        'idUser',
       'idTontine',
       'montant',
       'moyen_paiement'

       
    ];
}
