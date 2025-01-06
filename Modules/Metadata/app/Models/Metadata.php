<?php

namespace Modules\Metadata\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Models\Post;
use Modules\Product\Models\Product;

class Metadata extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];

    public function post()
    {
        return $this->morphTo(Post::class, 'metadataable');
    }

    public function products()
    {
        return $this->morphTo(Product::class, 'metadataable');
    }
}
