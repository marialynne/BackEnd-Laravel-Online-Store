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
class Order_type extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'order_types';

    /**
     * Store a newly created order status in storage.
     *
     * @param string $order_type_name;
     * @param string $order_type_description;
     * @return Order_type
     */
    public static function store (string $order_type_name, string $order_type_description): Order_type
    {
        $order_type= new Order_type();

        // Set values to new instance
        return self::setValuesToInstance($order_type, $order_type_name, $order_type_description);
    }

    /**
     * Update the specified order status in storage.
     *
     * @param string $order_type_name;
     * @param string $order_type_description;
     * @param order_type $order_type;
     * @return Order_type
     */
    public static function updateModel(string $order_type_name, string $order_type_description, Order_type $order_type): Order_type
    {
        // Set values to instance
        return self::setValuesToInstance($order_type, $order_type_name, $order_type_description);
    }

    /**
     * Set values to instance.
     *
     * @param Order_type $order_type;
     * @param string $order_type_name;
     * @param string $order_type_description;
     * @return Order_type
     */
    public static function setValuesToInstance(Order_type $order_type, string $order_type_name, string $order_type_description): Order_type
    {
        $order_type->order_type_name = $order_type_name;
        $order_type->order_type_description = $order_type_description;

        // Save in DB
        $order_type->save();

        return $order_type;
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
            $order_type = Order_type::orderby('order_type_name','asc')
                ->select('id','order_type_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $order_type = Order_type::orderby('order_type_name','asc')
                ->select('id','order_type_name')
                ->where('order_type_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($order_type)) {
            $res['pagination'] = array('more' => count($order_type) >= 5);
            foreach ($order_type as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->order_type_name));
            }
        }
        return $res;
    }
}
