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
class Unit extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'units';

    /**
     * Store a newly created unit in storage.
     *
     * @param string $unit_name;
     * @param string $unit_description;
     * @return Unit
     */
    public static function store (string $unit_name, string $unit_description): Unit
    {
        $unit = new Unit();

        // Set values to new instance
        return self::setValuesToInstance($unit, $unit_name, $unit_description);
    }

    /**
     * Update the specified unit in storage.
     *
     * @param string $unit_name;
     * @param string $unit_description;
     * @param Unit $unit;
     * @return Unit
     */
    public static function updateModel(string $unit_name, string $unit_description, Unit $unit): Unit
    {
        // Set values to instance
        return self::setValuesToInstance($unit, $unit_name, $unit_description);
    }

    /**
     * Set values to instance.
     *
     * @param Unit $unit;
     * @param string $unit_name;
     * @param string $unit_description;
     * @return Unit
     */
    public static function setValuesToInstance(unit $unit, string $unit_name, string $unit_description): Unit
    {
        $unit->unit_name = $unit_name;
        $unit->unit_description = $unit_description;

        // Save in DB
        $unit->save();

        return $unit;
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
            $unit = Unit::orderby('unit_name','asc')
                ->select('id','unit_name')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }else{
            $unit = Unit::orderby('unit_name','asc')
                ->select('id','unit_name')
                ->where('unit_name', 'like','%' .$search .'%')
                ->offset(5*($page-1))
                ->limit(5)
                ->get();
        }

        $res['results'] = array();

        if (!empty($unit)) {
            $res['pagination'] = array('more' => count($unit) >= 5);
            foreach ($unit as $m) {
                $res['results'][] = array('value'=> $m->id, 'text' => ($m->unit_name));
            }
        }
        return $res;
    }
}
