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
class User extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'users';

    /*
    protected $fillable = [
        'user_name','user_surnames','user_email','user_password'
    ];*/

    /**
     * Store a newly created user in storage.
     *
     * @param string $user_name;
     * @param string $user_surnames;
     * @param string $user_email;
     * @param string $user_profile_picture;
     * @param boolean $user_receive_notifications;
     * @param boolean $user_receive_recommendation;
     * @param integer $type_of_user_id;
     * @return User
     */
    public static function store (string $user_name, string $user_surnames, string $user_email, string $user_profile_picture, bool $user_receive_notifications, bool $user_receive_recommendation, int $type_of_user_id): User
    {
        $user = new User();

        // Set values to new instance
        return self::setValuesToInstance($user, $user_name, $user_surnames, $user_email, $user_profile_picture, $user_receive_notifications, $user_receive_recommendation, $type_of_user_id);
    }

    /**
     * Update the specified user in storage.
     *
     * @param string $user_name;
     * @param string $user_surnames;
     * @param string $user_email;
     * @param string $user_profile_picture;
     * @param boolean $user_receive_notifications;
     * @param boolean $user_receive_recommendation;
     * @param integer $type_of_user_id;
     * @param User $user;
     * @return User
     */
    public static function updateModel(string $user_name, string $user_surnames, string $user_email, string $user_profile_picture, bool $user_receive_notifications, bool $user_receive_recommendation, int $type_of_user_id, User $user): User
    {
        // Set values to instance
        return self::setValuesToInstance($user, $user_name, $user_surnames, $user_email, $user_profile_picture, $user_receive_notifications, $user_receive_recommendation, $type_of_user_id);
    }

    /**
     * Set values to instance.
     *
     * @param User $user;
     * @param string $user_name;
     * @param string $user_surnames;
     * @param string $user_email;
     * @param string $user_profile_picture;
     * @param boolean $user_receive_notifications;
     * @param boolean $user_receive_recommendation;
     * @param integer $type_of_user_id;
     * @return User
     */
    public static function setValuesToInstance(User $user, string $user_name, string $user_surnames, string $user_email, string $user_profile_picture, bool $user_receive_notifications, bool $user_receive_recommendation, int $type_of_user_id): user
    {
        $user->user_name = $user_name;
        $user->user_surnames = $user_surnames;
        $user->user_email = $user_email;
        $user->user_profile_picture = $user_profile_picture;
        $user->user_receive_notifications = $user_receive_notifications;
        $user->user_email = $user_email;
        $user->user_receive_recommendation = $user_receive_recommendation;
        $user->type_of_user_id = $type_of_user_id;


        // Save in DB
        $user->save();

        return $user;
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
            $user = User::orderby('user_name','asc')
                ->select('id','user_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $user = User::orderby('user_name','asc')
                ->select('id','user_name')
                ->where('user_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($user)) {
            $res['pagination'] = array('more' => count($user) >= 5);
            foreach ($user as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->user_name));
            }
        }
        return $res;
    }

    // Relations

    /**
     * @return HasOne
     */
    public function type_of_user_id (): HasOne
    {
        return $this->hasOne('App\Type_of_user', 'id', 'type_of_user_id');
    }
}
