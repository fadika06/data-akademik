<?php

Route::group(['prefix' => 'api/data-akademik', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@index',
        'create'    => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@create',
        'store'     => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@store',
        'show'      => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@show',
        'edit'      => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@edit',
        'update'    => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@update',
        'destroy'   => 'Bantenprov\DataAkademik\Http\Controllers\DataAkademikController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('data-akademik.index');
    Route::get('/create',       $controllers->create)->name('data-akademik.create');
    Route::post('/',            $controllers->store)->name('data-akademik.store');
    Route::get('/{id}',         $controllers->show)->name('data-akademik.show');
    Route::get('/{id}/edit',    $controllers->edit)->name('data-akademik.edit');
    Route::put('/{id}',         $controllers->update)->name('data-akademik.update');
    Route::delete('/{id}',      $controllers->destroy)->name('data-akademik.destroy');
});
