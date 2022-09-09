<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @method static exists()
 * @method static find(int $id)
 * @method static where(string $string, int $id)
 * @method static orderby(string $string, string $string1)
 */
class Ordered_product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'ordered_products';

    /**
     * Store a newly created ordered product in storage.
     *
     * @param integer $order_id;
     * @param integer $product_id;
     * @param double $products_order_amount;
     * @param double $products_order_cost;
     * @return Ordered_product
     */

    public static function store (int $order_id, int $product_id, float $products_order_amount, float $products_order_cost): Ordered_product
    {
        $ordered_product = new Ordered_product();

        // Set values to new instance
        return self::setValuesToInstance($ordered_product, $order_id, $product_id, $products_order_amount, $products_order_cost);
    }

    /**
     * Update the specified ordered product in storage.
     *
     * @param integer $order_id;
     * @param integer $product_id;
     * @param double $products_order_amount;
     * @param double $products_order_cost;
     * @param Ordered_product $ordered_product;
     * @return Ordered_product
     */
    public static function updateModel (int $order_id, int $product_id, float $products_order_amount, float $products_order_cost, Ordered_product $ordered_product): Ordered_product
    {
        // Set values to instance
        return self::setValuesToInstance($ordered_product, $order_id, $product_id, $products_order_amount, $products_order_cost);
    }

    /**
     * Set values to instance.
     *
     * @param Ordered_product $ordered_product;
     * @param integer $order_id;
     * @param integer $product_id;
     * @param double $products_order_amount;
     * @param double $products_order_cost;
     * @return Ordered_product
     */
    public static function setValuesToInstance(Ordered_product $ordered_product, int $order_id, int $product_id, float $products_order_amount, float $products_order_cost): Ordered_product
    {
        $ordered_product->order_id = $order_id;
        $ordered_product->product_id = $product_id;
        $ordered_product->products_order_amount = $products_order_amount;
        $ordered_product->products_order_cost = $products_order_cost;

        // Save in DB
        $ordered_product->save();

        return $ordered_product;
    }

    // Relations

    /**
     * @return HasOne
     */
    public function order_id (): HasOne
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }

    /**
     * @return HasOne
     */
    public function product_id (): HasOne
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
