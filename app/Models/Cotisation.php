<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    protected $fillable = [
        'idUser',
        'idTontine',
        'date_echeance', // ✅ Obligatoire
        'montant',
        'moyen_paiement',
        'statut'
       
    ];

    // Dans Cotisation.php
public function tontine()
{
    return $this->belongsTo(Tontine::class, 'idTontine');
}

}
