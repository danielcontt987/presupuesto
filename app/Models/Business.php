<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'business';

    protected $fillable = [
        'img',
        'name',
        'pin',
        'services',
        'street',
        'ext',
        'int',
        'colony_id',
        'telephone1',
        'telephone2',
        'whatsapp',
        'website',
        'facebook',
        'lat',
        'log',
        'fiscal_rfc',
        'fiscal_corporative_name',
        'fiscal_street',
        'fiscal_ext',
        'fiscal_int',
        'fiscal_colony_id',
        'timezone',
        'email',
        'email_company',
        'password',
        'internet',
        'cer',
        'key',
        'tax_regime',
        'cfdi',
        'folio_business',
        'long',
        'type_doc',
        'turn_id'
    ];

    public function turn()
    {
        return $this->hasOne(Turn::class, 'id', 'turn_id');
    }
}
