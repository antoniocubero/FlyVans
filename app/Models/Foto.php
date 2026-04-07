<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'fotos';

    protected $fillable = [
        'id_caravana',
        'url',
        'es_principal',
    ];

    public function caravana(){
        return $this->belongsTo(Caravana::class, 'id_caravana');
    }

    public function borrar(){
        $path = str_replace('/storage/', 'public/', $this->url);
        if(Storage::exists($path)){
            Storage::delete($path);
        }

        $this->delete();
    }
}
