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
class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'orders';

    /**
     * Store a newly created order in storage.
     *
     * @param string $order_date;
     * @param string $order_date_of_delivery;
     * @param integer $order_status_id;
     * @param integer $order_client_id;
     * @param integer $order_distributor_id;
     * @param integer $order_type_id;
     * @return Order
     */
    public static function store (string $order_date, string $order_date_of_delivery, int $order_status_id, int $order_client_id, int $order_distributor_id, int $order_type_id): order
    {
        $order = new Order();

        // Set values to new instance
        return self::setValuesToInstance($order, $order_date, $order_date_of_delivery, $order_status_id, $order_client_id, $order_distributor_id, $order_type_id);
    }

    /**
     * Update the specified order in storage.
     *
     * @param string $order_date;
     * @param string $order_date_of_delivery;
     * @param integer $order_status_id;
     * @param integer $order_client_id;
     * @param integer $order_distributor_id;
     * @param integer $order_type_id;
     * @param Order $order;
     * @return Order
     */
    public static function updateModel(string $order_date, string $order_date_of_delivery, int $order_status_id, int $order_client_id, int $order_distributor_id, int $order_type_id, order $order): order
    {
        // Set values to instance
        return self::setValuesToInstance($order, $order_date, $order_date_of_delivery, $order_status_id, $order_client_id, $order_distributor_id, $order_type_id);
    }

    /**
     * Set values to instance.
     *
     * @param order $order;
     * @param string $order_date;
     * @param string $order_date_of_delivery;
     * @param integer $order_status_id;
     * @param integer $order_client_id;
     * @param integer $order_distributor_id;
     * @param integer $order_type_id;
     * @return Order
     */
    public static function setValuesToInstance(Order $order, string $order_date, string $order_date_of_delivery, int $order_status_id, int $order_client_id, int $order_distributor_id, int $order_type_id): order
    {
        $order->order_date = $order_date;
        $order->order_date_of_delivery = $order_date_of_delivery;
        $order->order_status_id = $order_status_id;
        $order->order_client_id = $order_client_id;
        $order->order_distributor_id = $order_distributor_id;
        $order->order_type_id = $order_type_id;

        // Save in DB
        $order->save();

        return $order;
    }

    // Relations

    /**
     * @return HasOne
     */
    public function order_statuses_id (): HasOne
    {
        return $this->hasOne('App\Order_status', 'id', 'order_status_id');
    }

    /**
     * @return HasOne
     */
    public function order_client_id (): HasOne
    {
        return $this->hasOne('App\User', 'id', 'order_client_id');
    }

    /**
     * @return HasOne
     */
    public function order_distributor_id (): HasOne
    {
        return $this->hasOne('App\User', 'id', 'order_distributor_id');
    }

    /**
     * @return HasOne
     */
    public function order_type_id (): HasOne
    {
        return $this->hasOne('App\Order_type', 'id', 'order_type_id');
    }
}
