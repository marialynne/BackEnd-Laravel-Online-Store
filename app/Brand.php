<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static exists()
 * @method static find(int $id)
 * @method static where(string $string, int $id)
 * @method static orderby(string $string, string $string1)
 */
class Brand extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'brands';

    /**
     * Store a newly created brand in storage.
     *
     * @param string $brand_name;
     * @param string $brand_description;
     * @param string $brand_details;
     * @return Brand
     */

    public static function store (string $brand_name, string $brand_description, string $brand_details): brand
    {
        $brand = new Brand();

        // Set values to new instance
        return self::setValuesToInstance($brand, $brand_name, $brand_description, $brand_details);
    }

    /**
     * Update the specified brand in storage.
     *
     * @param string $brand_name;
     * @param string $brand_description;
     * @param string $brand_details;
     * @param Brand $brand;
     * @return Brand
     */
    public static function updateModel(string $brand_name, string $brand_description, string $brand_details, Brand $brand): Brand
    {
        // Set values to instance
        return self::setValuesToInstance($brand, $brand_name, $brand_description, $brand_details);
    }

    /**
     * Set values to instance.
     *
     * @param brand $brand;
     * @param string $brand_name;
     * @param string $brand_description;
     * @param string $brand_details;
     * @return Brand
     */
    public static function setValuesToInstance(Brand $brand, string $brand_name, string $brand_description, string $brand_details): Brand
    {
        $brand->brand_name = $brand_name;
        $brand->brand_description = $brand_description;
        $brand->brand_details = $brand_details;

        // Save in DB
        $brand->save();

        return $brand;
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
            $brand = Brand::orderby('brand_name','asc')
                ->select('id','brand_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $brand = Brand::orderby('brand_name','asc')
                ->select('id','brand_name')
                ->where('brand_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($brand)) {
            $res['pagination'] = array('more' => count($brand) >= 5);
            foreach ($brand as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->brand_name));
            }
        }
        return $res;
    }

}
