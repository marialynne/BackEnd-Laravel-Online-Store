<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

/**
 * @method static exists()
 * @method static find(int $id)
 * @method static where(string $string, int $id)
 * @method static orderby(string $string, string $string1)
 */
class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'products';

    /**
     * @param string $product_name;
     * @param string $product_key;
     * @param double $product_price;
     * @param double $product_cost;
     * @param string $product_image;
     * @param integer $brand_id;
     * @param integer $category_id;
     * @param string $product_model;
     * @param integer $unit_id;
     * @return Product
     */
    public static function store (string $product_name, string $product_key, float $product_price, float $product_cost, string $product_image, int $brand_id, int $category_id, string $product_model, int $unit_id): Product
    {
        $product = new Product();

        // Set values to new instance
        return self::setValuesToInstance($product, $product_name, $product_key, $product_price, $product_cost, $product_image, $category_id, $brand_id, $product_model, $unit_id);
    }

    /**
     * Update the specified product in storage.
     *
     * @param string $product_name ;
     * @param string $product_key ;
     * @param double $product_price ;
     * @param double $product_cost ;
     * @param string $product_image ;
     * @param integer $brand_id ;
     * @param integer $category_id ;
     * @param string $product_model ;
     * @param integer $unit_id ;
     * @param Product $product ;
     * @return Product
     */
    public static function updateModel (string $product_name, string $product_key, float $product_price, float $product_cost, string $product_image, int $brand_id, int $category_id, string $product_model, int $unit_id, Product $product): Product
    {
        // Set values to instance
        return self::setValuesToInstance($product, $product_name, $product_key, $product_price, $product_cost, $product_image, $category_id, $brand_id, $product_model, $unit_id);
    }

    /**
     * @param Product $product ;
     * @param string $product_name ;
     * @param string $product_key ;
     * @param double $product_price ;
     * @param double $product_cost ;
     * @param string $product_image ;
     * @param integer $category_id ;
     * @param integer $brand_id ;
     * @param string $product_model ;
     * @param integer $unit_id ;
     * @return Product
     */
    public static function setValuesToInstance(Product $product, string $product_name, string $product_key, float $product_price, float $product_cost, string $product_image, int $category_id, int $brand_id, string $product_model, int $unit_id): Product
    {
        $product->product_name = $product_name;
        $product->product_key = $product_key;
        $product->product_price = $product_price;
        $product->product_cost = $product_cost;
        $product->product_image = $product_image;
        $product->category_id = $category_id;
        $product->brand_id = $brand_id;
        $product->product_model = $product_model;
        $product->unit_id = $unit_id;

        // Save in DB
        $product->save();

        return $product;
    }

    /**
     * Return an array data of objects with value and name.
     *
     * @param integer $page
     * @param string $search
     * @return array
     */
    public static function select2 (int $page, string $search): array
    {
        if($search == ''){
            $product_name = Product::orderby('product_name','asc')
                ->select('id','product_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $product_name = Product::orderby('product_name','asc')
                ->select('id','product_name')
                ->where('product_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($product_name)) {
            $res['pagination'] = array('more' => count($product_name) >= 5);
            foreach ($product_name as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->product_name));
            }
        }
        return $res;
    }

    // Relations

    /**
     * @return HasOne
     */
    public function brand_id (): HasOne
    {
        return $this->hasOne('App\Brand', 'id', 'brand_id');
    }

    /**
     * @return HasOne
     */
    public function category_id (): HasOne
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    /**
     * @return HasOne
     */
    public function unit_id (): HasOne
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }
}
