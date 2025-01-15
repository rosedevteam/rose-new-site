<?php

namespace Modules\Cart\Classes\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Modules\Discount\Models\Discount;

class CartService
{
    protected $cart;

    protected $name = 'default';

    public function __construct()
    {
        $cart = collect(json_decode(request()->cookie($this->name), true));
        $this->cart = $cart->count() ? $cart : collect([
            'items' => [],
            'discount' => null
        ]);
    }


    /**
     * @param array $value
     * @param null $obj
     * @return $this
     */
    public function put(array $value, $obj = null)
    {

        if (!is_null($obj) && $obj instanceof Model) {
            if (!is_null($obj->sale_price)) {
                $price = $obj->sale_price;
            } else {
                $price = $obj->price;
            }
            $value = array_merge($value, [
                'id' => Str::random(10),
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj),
                'price' => $price,
                'discount_amount' => 0
            ]);
        } elseif (!isset($value['id'])) {
            $value = array_merge($value, [
                'id' => Str::random(10)
            ]);
        }

        $this->cart['items'] = collect($this->cart['items'])->put($value['id'], $value);
        $this->storeCookie();


        return $this;
    }

    public function update($key, $options)
    {
        $item = collect($this->get($key, false));
        if (is_numeric($options)) {
            $item = $item->merge([
                'quantity' => $item['quantity'] + $options
            ]);
        }

        if (is_array($options)) {
            $item = $item->merge($options);
        }

        $this->put($item->toArray());

        return $this;
    }

    public function count($key)
    {
        if (!$this->has($key)) return 0;

        return $this->get($key)['quantity'];
    }

    public function has($key)
    {
        if ($key instanceof Model) {
            return !is_null(
                collect($this->cart['items'])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            );
        }

        return !is_null(
            collect($this->cart['items'])->firstWhere('id', $key)
        );
    }

    public function get($key, $withRelationShip = true)
    {
        $item = $key instanceof Model
            ? collect($this->cart['items'])->where('subject_id', $key->id)->where('subject_type', get_class($key))->first()
            : collect($this->cart['items'])->firstWhere('id', $key);

        return $withRelationShip ? $this->withRelationshipIfExist($item) : $item;
    }

    public function delete($key)
    {
        if ($this->has($key)) {
            $this->cart['items'] = collect($this->cart['items'])->filter(function ($item) use ($key) {
                if ($key instanceof Model) {
                    return ($item['subject_id'] != $key->id) && ($item['subject_type'] != get_class($key));
                }
                return $key != $item['id'];
            });
            $this->storeCookie();

            return true;
        }

        return false;
    }

    public function all()
    {
        $cart = $this->cart;
        $cart = collect($this->cart['items'])->map(function ($item) use ($cart) {
            $item = $this->withRelationshipIfExist($item);
            $item = $this->checkDiscountValidate($item, $cart['discount']);
            return $item;

        });
        return $cart;
    }

    public function flush()
    {
        $this->cart = collect([
            'items' => [],
            'discount' => null
        ]);
        $this->storeCookie();

        return $this;
    }

    protected function withRelationshipIfExist($item)
    {
        if (isset($item['subject_id']) && isset($item['subject_type'])) {
            $class = $item['subject_type'];
            $subject = (new $class())->find($item['subject_id']);

            $item[strtolower(class_basename($class))] = $subject;

            unset($item['subject_id']);
            unset($item['subject_type']);

            return $item;
        }


        return $item;
    }

    public function instance(string $name)
    {
        $cart = collect(json_decode(request()->cookie($name), true));
        $this->cart = $cart->count() ? $cart : collect([
            'items' => [],
            'discount' => null
        ]);
        $this->name = $name;
        return $this;
    }

    public function addDiscount($discount)
    {
        $this->cart['discount'] = $discount;
        $this->storeCookie();
    }

    public function getDiscount()
    {
        return Discount::where('code', $this->cart['discount'])->where('is_active', 1)->first();
    }

    protected function storeCookie(): void
    {
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 7);
    }

    protected function checkDiscountValidate($item, $discount)
    {
        $discount = Discount::where('code', $discount)->where('is_active', 1)->first();
//        $product = Product::findOrFail($item['product']->id);
//
//        if (is_Null($discount)) return $item;
//        if ($discount->expires_at < now()) return $item;
//        if (!$discount->products->contains($product)) return $item;
//        if ($discount->discountRecords()->where('user_id', auth()->id())->count() == $discount->limit) return $item;
//
//        if ($discount->type == 'amount') {
//            $item['discount_amount'] = $discount->amount;
//        } else {
//            $item['discount_amount'] = ($discount->amount / 100) * ($product->sale_price ?: $product->price);
//        }

        if ($discount && $discount->expires_at > now()) {
            if (
                (!$discount->products->count()) ||
                in_array($item['product']->id, $discount->products->pluck('id')->toArray())) {
            }
        }
        return $item;
    }
}
