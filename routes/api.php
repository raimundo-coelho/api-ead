<?php


Route::group(['namespace' => 'Api'], function () {

    Route::name('api.login')->post('login', 'AuthController@login');


    Route::post('refresh', 'AuthController@refresh');


    Route::apiResource('courses', 'CourseController');

    Route::post('send_sms', 'AuthController@sendSMS');
    Route::post('new_user', 'AuthController@newUser')->name('new_user');


    Route::group(['middleware' => ['auth:api']], function () {

        Route::post('logout', 'AuthController@logout');

        /*pag seguro*/
        Route::get('/session', 'PagSeguroController@createSession');
        Route::post('/payment', 'PagSeguroController@switchPayment')->name('payment');

        // Route::group(['middleware' => 'jwt.refresh'], function () { });

        Route::post('/user', 'UserController@show');
        Route::put('/user/{user}', 'UserController@update');
        Route::put('/user/password/{course}', 'UpdatePasswordController@update');


        Route::get('categories/{category}/bill_pays', 'CategoryBillPayController@index');
        Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
        Route::resource('bill_pays', 'BillPayController', ['except' => ['create', 'edit']]);


        Route::apiResource('users', 'UsersController', ['except' => ['store']]);
        Route::apiResource('categories', 'CategoryController');
        Route::apiResource('lessons', 'LessonController');
        Route::apiResource('managers', 'ManagerController');
        Route::apiResource('threads', 'ThreadsController');
        Route::apiResource('replies', 'ReplyController');





    });


});
