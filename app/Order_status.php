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
class Order_status extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'order_statuses';

    /**
     * Store a newly created order status in storage.
     *
     * @param string $order_status_name;
     * @param string $order_status_description;
     * @return Order_status
     */
    public static function store (string $order_status_name, string $order_status_description): Order_status
    {
        $order_status= new Order_status();

        // Set values to new instance
        return self::setValuesToInstance($order_status, $order_status_name, $order_status_description);
    }

    /**
     * Update the specified order status in storage.
     *
     * @param string $order_status_name;
     * @param string $order_status_description;
     * @param Order_status $order_status;
     * @return Order_status
     */
    public static function updateModel(string $order_status_name, string $order_status_description, Order_status $order_status): Order_status
    {
        // Set values to instance
        return self::setValuesToInstance($order_status, $order_status_name, $order_status_description);
    }

    /**
     * Set values to instance.
     *
     * @param order_status $order_status;
     * @param string $order_status_name;
     * @param string $order_status_description;
     * @return Order_status
     */
    public static function setValuesToInstance(Order_status $order_status, string $order_status_name, string $order_status_description): Order_status
    {
        $order_status->order_status_name = $order_status_name;
        $order_status->order_status_description = $order_status_description;

        // Save in DB
        $order_status->save();

        return $order_status;
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
            $order_status = Order_status::orderby('order_status_name','asc')
                ->select('id','order_status_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $order_status = Order_status::orderby('order_status_name','asc')
                ->select('id','order_status_name')
                ->where('order_status_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($order_status)) {
            $res['pagination'] = array('more' => count($order_status) >= 5);
            foreach ($order_status as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->order_status_name));
            }
        }
        return $res;
    }
}
