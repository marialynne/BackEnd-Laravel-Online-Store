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
class Type_of_user extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'type_of_users';

    /**
     * Store a newly created type of user in storage.
     *
     * @param string $type_of_user_name;
     * @param string $type_of_user_description;
     * @return Type_of_user
     */
    public static function store (string $type_of_user_name, string $type_of_user_description): Type_of_user
    {
        $type_of_user = new Type_of_user();

        // Set values to new instance
        return self::setValuesToInstance($type_of_user, $type_of_user_name, $type_of_user_description);
    }

    /**
     * Update the specified type of user in storage.
     *
     * @param string $type_of_user_name;
     * @param string $type_of_user_description;
     * @param Type_of_user $type_of_user;
     * @return Type_of_user
     */
    public static function updateModel(string $type_of_user_name, string $type_of_user_description, Type_of_user $type_of_user): Type_of_user
    {
        // Set values to instance
        return self::setValuesToInstance($type_of_user, $type_of_user_name, $type_of_user_description);
    }

    /**
     * Set values to instance.
     *
     * @param Type_of_user $type_of_user;
     * @param string $type_of_user_name;
     * @param string $type_of_user_description;
     * @return Type_of_user
     */
    public static function setValuesToInstance(Type_of_user $type_of_user, string $type_of_user_name, string $type_of_user_description): Type_of_user
    {
        $type_of_user->type_of_user_name = $type_of_user_name;
        $type_of_user->type_of_user_description = $type_of_user_description;

        // Save in DB
        $type_of_user->save();

        return $type_of_user;
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
            $type_of_user = Type_of_user::orderby('type_of_user_name','asc')
                ->select('id','type_of_user_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $type_of_user = Type_of_user::orderby('type_of_user_name','asc')
                ->select('id','type_of_user_name')
                ->where('type_of_user_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($type_of_user)) {
            $res['pagination'] = array('more' => count($type_of_user) >= 5);
            foreach ($type_of_user as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->type_of_user_name));
            }
        }
        return $res;
    }
}
