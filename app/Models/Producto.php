<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'update_at'];

    const DESACTIVADO = 0;
    const ACTIVADO = 1;

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function imagenes()
    {
        return $this->morphMany(Imagen::class, "imagenable");
    }

    public function ckeditors()
    {
        return $this->morphMany(Ckeditor::class, "ckeditorable");
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
