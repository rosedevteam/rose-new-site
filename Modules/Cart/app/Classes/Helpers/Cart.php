<?php

namespace Modules\Cart\Classes\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class Cart
 * @package App\Helpers\Cart
 * @method static bool has($id)
 * @method static Collection all();
 * @method static array get($id);
 * @method static \Modules\Cart\App\Http\Cart\Helpers\Cart put(array $value , Model $obj = null)
 * @method static Cart instance(string $name)
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}

