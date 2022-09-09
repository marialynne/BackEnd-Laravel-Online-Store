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
class Notification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'notifications';

    /**
     * Store a newly created notification in storage.
     *
     * @param string $notification_name;
     * @param string $notification_description;
     * @param integer $notification_type_id;
     * @return Notification
     */

    public static function store (string $notification_name, string $notification_description, int $notification_type_id): Notification
    {
        $notification = new Notification();

        // Set values to new instance
        return self::setValuesToInstance($notification, $notification_name, $notification_description, $notification_type_id);
    }

    /**
     * Update the specified notification in storage.
     *
     * @param string $notification_name;
     * @param string $notification_description;
     * @param integer $notification_type_id;
     * @param Notification $notification;
     * @return Notification
     */
    public static function updateModel (string $notification_name, string $notification_description, int $notification_type_id, Notification $notification): Notification
    {
        // Set values to instance
        return self::setValuesToInstance($notification, $notification_name, $notification_description, $notification_type_id);
    }

    /**
     * Set values to instance.
     *
     * @param Notification $notification;
     * @param string $notification_name;
     * @param string $notification_description;
     * @param integer $notification_type_id;
     * @return Notification
     */
    public static function setValuesToInstance(Notification $notification, string $notification_name, string $notification_description, int $notification_type_id): Notification
    {
        $notification->notification_name = $notification_name;
        $notification->notification_description = $notification_description;
        $notification->notification_type_id = $notification_type_id;

        // Save in DB
        $notification->save();

        return $notification;
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
            $notification = Notification::orderby('notification_name','asc')
                ->select('id','notification_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $notification = Notification::orderby('notification_name','asc')
                ->select('id','notification_name')
                ->where('notification_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($notification)) {
            $res['pagination'] = array('more' => count($notification) >= 5);
            foreach ($notification as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->notification_name));
            }
        }
        return $res;
    }

    // Relations

    /**
     * @return HasOne
     */
    public function notification_type_id (): HasOne
    {
        return $this->hasOne('App\Notification_type', 'id', 'notification_type_id');
    }
}
