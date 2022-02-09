<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductContractMapping extends Model
{
    protected $table ='product_contract_mappings';
    use HasFactory;
    use SoftDeletes;

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function products(){
        return  $this->hasOne(Product::class,'id','product_id');
    }









}
