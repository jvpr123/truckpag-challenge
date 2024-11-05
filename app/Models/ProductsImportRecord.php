<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsImportRecord extends Model
{
    use HasFactory;

    protected $fillable = ['success', 'imported_file'];

    protected $casts = ['success' => 'boolean'];
}
