<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boleto extends Model {

    protected $table = 'boletos';
    protected $primaryKey = 'id_boleto';

    protected $fillable = [
        'id_boleto',
        'name', 
        'government_id', 
        'email', 
        'debt_amount', 
        'debt_due_date', 
        'debt_id'
    ];

}
