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
class Notification_type extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'notification_types';

    /**
     * Store a newly created notification type in storage.
     *
     * @param string $notification_type_name;
     * @return Notification_type
     */

    public static function store (string $notification_type_name): Notification_type
    {
        $notification_type = new Notification_type();

        // Set values to new instance
        return self::setValuesToInstance($notification_type, $notification_type_name);
    }

    /**
     * Update the specified notification type in storage.
     *
     * @param string $notification_type_name;
     * @param Notification_type $notification_type;
     * @return Notification_type
     */
    public static function updateModel (string $notification_type_name, Notification_type $notification_type): Notification_type
    {
        // Set values to instance
        return self::setValuesToInstance($notification_type, $notification_type_name);
    }

    /**
     * Set values to instance.
     *
     * @param Notification_type $notification_type;
     * @param string $notification_type_name;
     * @return Notification_type
     */
    public static function setValuesToInstance(Notification_type $notification_type, string $notification_type_name): Notification_type
    {
        $notification_type->notification_type_name = $notification_type_name;

        // Save in DB
        $notification_type->save();

        return $notification_type;
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
            $notification_type = Notification_type::orderby('notification_type_name','asc')
                ->select('id','notification_type_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $notification_type = Notification_type::orderby('notification_type_name','asc')
                ->select('id','notification_type_name')
                ->where('notification_type_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($notification_type)) {
            $res['pagination'] = array('more' => count($notification_type) >= 5);
            foreach ($notification_type as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->notification_type_name));
            }
        }
        return $res;
    }
}
