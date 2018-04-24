<?php

Route::group(['prefix' => 'passing-grade'], function() {
    Route::get('demo', 'Bantenprov\PassingGrade\Http\Controllers\PassingGradeController@demo');
});
