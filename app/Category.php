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
class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'categories';

    /**
     * Store a newly created category in storage.
     *
     * @param string $category_name;
     * @param double $category_tax;
     * @return Category
     */

    public static function store (string $category_name, float $category_tax): Category
    {
        $category = new Category();

        // Set values to new instance
        return self::setValuesToInstance($category, $category_name, $category_tax);
    }

    /**
     * Update the specified category in storage.
     *
     * @param string $category_name;
     * @param double $category_tax;
     * @param Category $category;
     * @return Category
     */
    public static function updateModel (string $category_name, float $category_tax, Category $category): Category
    {
        // Set values to instance
        return self::setValuesToInstance($category, $category_name, $category_tax);
    }

    /**
     * Set values to instance.
     *
     * @param category $category;
     * @param string $category_name;
     * @param double $category_tax;
     * @return Category
     */
    public static function setValuesToInstance(Category $category, string $category_name, float $category_tax): Category
    {
        $category->category_name = $category_name;
        $category->category_tax = $category_tax;

        // Save in DB
        $category->save();

        return $category;
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
            $category = Category::orderby('category_name','asc')
                ->select('id','category_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $category = Category::orderby('category_name','asc')
                ->select('id','category_name')
                ->where('category_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($category)) {
            $res['pagination'] = array('more' => count($category) >= 5);
            foreach ($category as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->category_name));
            }
        }
        return $res;
    }
}
