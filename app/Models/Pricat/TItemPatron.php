<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TItemPatron extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_item_patron';

    protected $fillable = [
        'ipa_item',
        'ipa_numtendidos',
        'ipa_cajten',
        'ipa_tenest',
        'ipa_undten',
        'ipa_undest',
        'ipa_caest'
    ];

    public function items()
  	{
  		  return $this->belongsTo('App\Models\Pricat\TItem', 'ipa_item');
  	}
}
