<?php namespace Bantenprov\PassingGrade\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\PassingGrade\Facades\PassingGrade;
use Bantenprov\PassingGrade\Models\PassingGradeModel;

/**
 * The PassingGradeController class.
 *
 * @package Bantenprov\PassingGrade
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PassingGradeController extends Controller
{
    public function demo()
    {
        return PassingGrade::welcome();
    }
}
