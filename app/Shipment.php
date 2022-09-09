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
class shipment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'shipments';

    /**
     * Store a newly created shipment in storage.
     *
     * @param integer $service_id;
     * @param integer $ordered_product_id;
     * @return shipment
     */
    public static function store (int $service_id, int $ordered_product_id): shipment
    {
        $shipment = new shipment();

        // Set values to new instance
        return self::setValuesToInstance($shipment, $service_id, $ordered_product_id);
    }

    /**
     * Update the specified shipment in storage.
     *
     * @param integer $service_id ;
     * @param integer $ordered_product_id ;
     * @param shipment $shipment;
     * @return shipment
     */
    public static function updateModel(int $service_id, int $ordered_product_id, shipment $shipment): shipment
    {
        // Set values to instance
        return self::setValuesToInstance($shipment, $service_id, $ordered_product_id);
    }

    /**
     * Set values to instance.
     *
     * @param shipment $shipment;
     * @param integer $service_id ;
     * @param integer $ordered_product_id ;
     * @return shipment
     */
    public static function setValuesToInstance(shipment $shipment, int $service_id, int $ordered_product_id): shipment
    {
        $shipment->service_id = $service_id;
        $shipment->ordered_product_id = $ordered_product_id;

        // Save in DB
        $shipment->save();

        return $shipment;
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
    public function ordered_product_id (): HasOne
    {
        return $this->hasOne('App\Ordered_product', 'id', 'ordered_product_id');
    }
}
