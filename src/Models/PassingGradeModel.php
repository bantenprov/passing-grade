<?php namespace Bantenprov\PassingGrade\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The PassingGradeModel class.
 *
 * @package Bantenprov\PassingGrade
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PassingGradeModel extends Model
{
    /**
    * Table name.
    *
    * @var string
    */
    protected $table = 'passing_grade';

    /**
    * The attributes that are mass assignable.
    *
    * @var mixed
    */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
