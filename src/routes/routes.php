<?php

Route::group(['prefix' => 'api/passing-grade-public', 'middleware' => ['web']], function() {
    $class          = 'Bantenprov\PassingGrade\Http\Controllers\PassingGradeController';
    $name           = 'passing-grade-public';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',                 $controllers->index)->name($name.'.index')->middleware([]);
    Route::get('/get',              $controllers->get)->name($name.'.get')->middleware([]);
    Route::get('/create',           $controllers->create)->name($name.'.create')->middleware([]);
    Route::get('/{id}/{track?}',    $controllers->show)->name($name.'.show')->middleware([]);
    Route::post('/',                $controllers->store)->name($name.'.store')->middleware([]);
    Route::get('/{id}/edit',        $controllers->edit)->name($name.'.edit')->middleware([]);
    Route::put('/{id}',             $controllers->update)->name($name.'.update')->middleware([]);
    Route::delete('/{id}',          $controllers->destroy)->name($name.'.destroy')->middleware([]);
});

Route::group(['prefix' => 'api/passing-grade', 'middleware' => ['auth', 'role:superadministrator|admin_sekolah']], function() {
    $class          = 'Bantenprov\PassingGrade\Http\Controllers\PassingGradeController';
    $name           = 'passing-grade';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',                 $controllers->index)->name($name.'.index')->middleware(['role:superadministrator|admin_sekolah']);
    Route::get('/get',              $controllers->get)->name($name.'.get')->middleware(['role:superadministrator|admin_sekolah']);
    Route::get('/create',           $controllers->create)->name($name.'.create')->middleware(['role:superadministrator|admin_sekolah']);
    Route::get('/{id}/{track?}',    $controllers->show)->name($name.'.show')->middleware(['role:superadministrator|admin_sekolah']);
    Route::post('/',                $controllers->store)->name($name.'.store')->middleware(['role:superadministrator|admin_sekolah']);
    Route::get('/{id}/edit',        $controllers->edit)->name($name.'.edit')->middleware(['role:superadministrator|admin_sekolah']);
    Route::put('/{id}',             $controllers->update)->name($name.'.update')->middleware(['role:superadministrator|admin_sekolah']);
    Route::delete('/{id}',          $controllers->destroy)->name($name.'.destroy')->middleware(['role:superadministrator|admin_sekolah']);
});
