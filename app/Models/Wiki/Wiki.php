<?php

namespace App\Models\Wiki;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracao\Wiki\Modelo;
use App\Models\Configuracao\Wiki\Fabricante;


class Wiki extends Model
{
    use HasFactory;


    public function fabricante() {
        return $this->belongsTo(Fabricante::class);
    }
}
