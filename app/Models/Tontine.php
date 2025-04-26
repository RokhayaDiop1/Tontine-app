<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    protected $fillable = [
        'frequence',
        'libelle',
        'dateDebut',
        'dateFin',
        'description',
        'montant_total',
        'montant_de_base',
        'nbreParticipant',
        'user_id',
        'inscription_ouvert',
    ];

    
    protected $casts = [
        'inscription_ouvert' => 'boolean',
    ];
    

public function gerant()
{
    return $this->belongsTo(User::class, 'user_id');
}

// public function participants()
// {
//     return $this->belongsToMany(User::class, 'tontine_participants')
//                 ->withPivot(['ordre_de_passage', 'statut'])
//                 ->withTimestamps();
// }



public function getInscriptionStatusAttribute()
{
    $actuels = $this->participants()->count();
    
    if (!$this->inscription_ouvert || $actuels >= $this->nbreParticipant) {
        return 'Fermée';
    }

    return 'Ouverte';
}


// Et une relation participants si elle n'existe pas encore :
public function participants()
{
    return $this->hasMany(Participant::class, 'tontine_id');
}


}
