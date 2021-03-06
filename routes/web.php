<?php

/*
|--------------------------------------------------------------------------
| Canvas Application Routes : Frontend
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', 'Frontend\BlogController@index')->name('home');
Route::post('/', 'Frontend\BlogController@search')->name('home.search');

Route::get('facebook/login', 'Auth\LoginController@redirectToProvider');
Route::get('facebook/login/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(['prefix' => 'blog'], function () {
    // Blog Index Page
    Route::get('/', 'Frontend\BlogController@index')->name('blog.post.index');
    // Blog Post Page
    Route::get('{slug}', 'Frontend\BlogController@showPost')->name('blog.post.show');
});

/*
|--------------------------------------------------------------------------
| Canvas Application Routes : Backend
|--------------------------------------------------------------------------
*/
Route::group([
    'namespace'  => 'Backend',
    'middleware' => 'auth',
], function () {
    // Home Page
    Route::get('admin', 'HomeController@index');

    // Posts Page
    Route::resource('admin/post', 'PostController', [
        'except' => 'show',
        'names' => [
            'index' => 'admin.post.index',
            'create' => 'admin.post.create',
            'store' => 'admin.post.store',
            'edit' => 'admin.post.edit',
            'update' => 'admin.post.update',
            'destroy' => 'admin.post.destroy',
        ],
    ]);

    Route::group([
        'middleware' => ['auth','admin']
    ], function () {
        // Tags Page
        Route::resource('admin/tag', 'TagController', [
            'except' => 'show',
            'names' => [
                'index' => 'admin.tag.index',
                'create' => 'admin.tag.create',
                'store' => 'admin.tag.store',
                'edit' => 'admin.tag.edit',
                'update' => 'admin.tag.update',
                'destroy' => 'admin.tag.destroy',
            ],
        ]);
        // Location Page
        Route::resource('admin/location', 'LocationController', [
            'except' => 'show',
            'names' => [
                'index' => 'admin.location.index',
                'create' => 'admin.location.create',
                'store' => 'admin.location.store',
                'edit' => 'admin.location.edit',
                'update' => 'admin.location.update',
                'destroy' => 'admin.location.destroy',
            ],
        ]);
    });
    // Uploads Page
    Route::get('admin/upload', 'UploadController@index')->name('admin/upload');
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');


    // Profile Pages
    Route::get('admin/profile/privacy', 'ProfileController@editPrivacy')->name('admin.profile.privacy');
    Route::resource('admin/profile', 'ProfileController', [
        'only' => ['index', 'edit', 'update'],
        'names' => [
            'index' => 'admin.profile.index',
            'edit' => 'admin.profile.edit',
            'update' => 'admin.profile.update',
        ],
    ]);

    // Search Page
    Route::resource('admin/search', 'SearchController', [
        'only' => ['index'],
        'names' => [
            'index' => 'admin.search.index',
        ],
    ]);

    // // Tools Page
    // Route::get('admin/tools', 'ToolsController@index');
    // Route::post('admin/tools/reset_index', 'ToolsController@resetIndex');
    // Route::post('admin/tools/cache_clear', 'ToolsController@clearCache');
    // Route::post('admin/tools/download_archive', 'ToolsController@handleDownload');
    // Route::post('admin/tools/enable_maintenance_mode', 'ToolsController@enableMaintenanceMode');
    // Route::post('admin/tools/disable_maintenance_mode', 'ToolsController@disableMaintenanceMode');

    // // Settings Page
    // Route::get('admin/settings', 'SettingsController@index');
    // Route::post('admin/settings', 'SettingsController@store');

    // // Help Page
    // Route::get('admin/help', 'HelpController@index');
});


Route::group([
    'namespace'  => 'Backend',
    'middleware' => ['auth','admin']
], function () {
       // Tools Page
    Route::get('admin/tools', 'ToolsController@index');
    Route::post('admin/tools/reset_index', 'ToolsController@resetIndex');
    Route::post('admin/tools/cache_clear', 'ToolsController@clearCache');
    Route::post('admin/tools/download_archive', 'ToolsController@handleDownload');
    Route::post('admin/tools/enable_maintenance_mode', 'ToolsController@enableMaintenanceMode');
    Route::post('admin/tools/disable_maintenance_mode', 'ToolsController@disableMaintenanceMode');

    // Settings Page
    Route::get('admin/settings', 'SettingsController@index');
    Route::post('admin/settings', 'SettingsController@store');

    // Help Page
    Route::get('admin/help', 'HelpController@index');
});
/*
|--------------------------------------------------------------------------
| Canvas Application Routes : Authentication
|--------------------------------------------------------------------------
*/

// add user registion 
Route::group([
    'namespace' => 'Auth','middleware'=>['web']], function () {
    Route::get('/register',  'RegisterController@index')->name('auth.register');

    Route::post('/register',  'RegisterController@create')->name('auth.create');

});

Route::group([
    'namespace' => 'Auth',
], function () {
    Route::group(['prefix' => 'auth'], function () {
        // Login
        Route::post('login', 'LoginController@login')->name('auth.login.store');

        // Logout
        Route::get('logout', 'LoginController@logout')->name('auth.logout');

        // Passwords
        Route::post('password', 'PasswordController@updatePassword');

        // Route::get('/register', 'RegisterController@create');
    });

    Route::group(['prefix' => 'password'], function () {
        // Forgot password
        Route::get('forgot', 'ForgotPasswordController@showLinkRequestForm')->name('auth.password.forgot');
        Route::post('forgot', 'ForgotPasswordController@sendResetLinkEmail')->name('auth.password.forgot.store');

        // Forgot password
        Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('auth.password.reset');
        Route::post('reset', 'ResetPasswordController@reset')->name('auth.password.reset.store');
    });
});

  