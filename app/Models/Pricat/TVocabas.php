<?php

namespace App\Models\Pricat;

use Illuminate\Database\Eloquent\Model;

class TVocabas extends Model
{
    protected $connection = 'pricat';

    protected $table = 't_vocabas';

    protected $fillable = [
        'tvoc_palabra',
        'tvoc_abreviatura'
    ];
}
