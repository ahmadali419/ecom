<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function cover_images()
    {
        return  $this->hasManyThrough(StoreCoverImage::class,StoreSetting::class,'store_id','store_setting_id','id','id');

        // return $this->hasManyThrough(StoreCoverImage::class, 'store_id', 'id');
    }
}
