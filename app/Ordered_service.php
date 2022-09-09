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
class ordered_service extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'ordered_services';

    /**
     * Store a newly created ordered service in storage.
     *
     * @param integer $service_id;
     * @param integer $order_id;
     * @param double $service_order_cost;
     * @return ordered_service
     */

    public static function store (int $service_id, int $order_id, float $service_order_cost): ordered_service
    {
        $ordered_service = new ordered_service();

        // Set values to new instance
        return self::setValuesToInstance($ordered_service, $service_id, $order_id, $service_order_cost);
    }

    /**
     * Update the specified ordered service in storage.
     *
     * @param integer $service_id;
     * @param integer $order_id;
     * @param double $service_order_cost;
     * @param ordered_service $ordered_service;
     * @return ordered_service
     */
    public static function updateModel (int $service_id, int $order_id, float $service_order_cost, ordered_service $ordered_service): ordered_service
    {
        // Set values to instance
        return self::setValuesToInstance($ordered_service, $service_id, $order_id, $service_order_cost);
    }

    /**
     * Set values to instance.
     *
     * @param ordered_service $ordered_service;
     * @param integer $service_id;
     * @param integer $order_id;
     * @param double $service_order_cost;
     * @return ordered_service
     */
    public static function setValuesToInstance(ordered_service $ordered_service, int $service_id, int $order_id, float $service_order_cost): ordered_service
    {
        $ordered_service->service_id = $service_id;
        $ordered_service->order_id = $order_id;
        $ordered_service->service_order_cost = $service_order_cost;

        // Save in DB
        $ordered_service->save();

        return $ordered_service;
    }

    // Relations

    /**
     * @return HasOne
     */
    public function service_id (): HasOne
    {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }

    /**
     * @return HasOne
     */
    public function order_id (): HasOne
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }
}
