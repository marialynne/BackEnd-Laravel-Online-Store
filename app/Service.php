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
class Service extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'services';

    /**
     * Store a newly created service in storage.
     *
     * @param string $service_name;
     * @param string $service_description;
     * @return Service
     */
    public static function store (string $service_name, string $service_description): Service
    {
        $service = new Service();

        // Set values to new instance
        return self::setValuesToInstance($service, $service_name, $service_description);
    }

    /**
     * Update the specified service in storage.
     *
     * @param string $service_name;
     * @param string $service_description;
     * @param Service $service;
     * @return Service
     */
    public static function updateModel(string $service_name, string $service_description, Service $service): Service
    {
        // Set values to instance
        return self::setValuesToInstance($service, $service_name, $service_description);
    }

    /**
     *  Set values to instance.
     * @param Service $service;
     * @param string $service_name;
     * @param string $service_description;
     * @return Service
     */
    public static function setValuesToInstance(Service $service, string $service_name, string $service_description): Service
    {
        $service->service_name = $service_name;
        $service->service_description = $service_description;

        // Save in DB
        $service->save();

        return $service;
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
            $service = Service::orderby('service_name','asc')
                ->select('id','service_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $service = Service::orderby('service_name','asc')
                ->select('id','service_name')
                ->where('service_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($service)) {
            $res['pagination'] = array('more' => count($service) >= 5);
            foreach ($service as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->service_name));
            }
        }
        return $res;
    }
}
