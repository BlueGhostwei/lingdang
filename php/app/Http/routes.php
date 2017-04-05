<?php

/*
|--------------------------------------------------------------------------
| 应用路由
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*Route::group(['namespace' => 'Home'], function () {
    //前台页面路由开始
    Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);
//验证码
    Route::get('yanzheng/test',['as'=>'captcha.test','uses'=>'Admin\CaptchaController@index']);
//生成
    Route::get('yanzheng/mews',['as'=>'captcha.mews','uses'=>'Admin\CaptchaController@mews']);
//验证验证码
    Route::any('yanzheng/cpt',['as'=>'captcha.cpt','uses'=>'Admin\CaptchaController@cpt']);


});*/




// 游客状态下的路由
Route::group(['middleware' => 'guest'], function () {
    Route::group(['namespace' => 'Admin'], function () {
        // 登录注册
        Route::get('Admin/user/login', ['as' => 'user.login', 'uses' => 'UserController@getLogin']);
        Route::post('Admin/user/login', 'UserController@postLogin');
        Route::get('/user/register', ['as' => 'user.register', 'uses' => 'UserController@getRegister']);
        Route::post('/user/register', 'UserController@postRegister');
        Route::get('/user/register/step2', ['as' => 'user.register.step2', 'uses' => 'UserController@getRegisterStep2']);
        Route::post('/user/register/step2', 'UserController@postRegisterStep2');
        Route::get('/user/register/step3', ['as' => 'user.register.step3', 'uses' => 'UserController@getRegisterStep3']);
        Route::post('/user/register/step3', 'UserController@postRegisterStep3');
        // 找回密码
        Route::get('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
        Route::post('password/email', 'Auth\PasswordController@postEmail');
        Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
        Route::post('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);
        //ios
        Route::get('user/send_sms', ['as' => 'send_sms', 'uses' => 'UserController@Send_sms']);
    });
});

// 需要登录状态的路由
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('/',['as'=>'admin.dashboard','uses'=>'DashboardController@index'] );
        // 需要登录状态和权限控制的路由
        Route::group(['middleware' => ['auth', 'acl']], function () {
            Route::get('admin/system/logs', ['as' => 'system.logs', 'uses' => 'SystemController@logs']);
            Route::get('admin/system/action', ['as' => 'system.action', 'uses' => 'SystemController@action']);
            Route::get('admin/system/login-history', ['as' => 'system.login-history', 'uses' => 'SystemController@loginHistory']);
            // 权限配置
            Route::any('/admin/acl/resource', ['as' => 'admin.acl.resource.index', 'uses' => 'AclResourceController@index']);
            Route::any('/admin/acl/role', ['as' => 'admin.role.index', 'uses' => 'AclRoleController@index']);
            Route::get('/acl/role/user_edit/{id}', ['as' => 'acl.role.user_edit', 'uses' => 'AclRoleController@user_edit']);
            Route::any('/acl/role/user_role_update/{id}', ['as' => 'acl.role.user_role_update', 'uses' => 'AclRoleController@user_role_update']);

            Route::resource('/acl/resource', 'AclResourceController');
            Route::resource('/acl/role', 'AclRoleController');
            Route::resource('/acl/user', 'AclUserController');
            Route::any('user_role', 'AclUserController@user_role');
            // 用户中心
            Route::get('/Admin/user/{id}', ['as' => 'user.show', 'uses' => 'UserController@show']);
            Route::get('/user/logout', ['as' => 'user.logout', 'uses' => 'UserController@getLogout']);
            Route::any('Admin/user/my', ['as' => 'user.my', 'uses' => 'UserController@my']);
            Route::get('/Admin/user/search', ['as' => 'user.search', 'uses' => 'UserController@search']);
            Route::get('admin/user/edit/{id}', ['as' => 'admin.user.edit', 'uses' => 'UserController@edit']);
            Route::get('Admin/user', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
            Route::get('Admin/user/trash/{id}', ['as' => 'user.trash', 'uses' => 'UserController@trash']);
            Route::get('Admin/user/create', ['as' => 'admin.user.create', 'uses' => 'UserController@create']);
            Route::get('user/{id}/restore', ['as' => 'user.restore', 'uses' => 'UserController@restore']);
            Route::post('/user/{id}/lock', ['as' => 'user.lock', 'uses' => 'UserController@lock']);
            Route::post('/user/{id}/unlock', ['as' => 'user.unlock', 'uses' => 'UserController@unlock']);
            Route::post('admin/user/store', ['as' => 'admin.user.store', 'uses' => 'UserController@store']);
            Route::resource('user', 'UserController');
            //项目管理
            Route::get('/project/store', ['as' => 'project.store', 'uses' => 'Management_ProController@store']);
            Route::get('/project/list', ['as' => 'project.list', 'uses' => 'Management_ProController@Project_list']);
            Route::get('/project/Set', ['as' => 'project.set', 'uses' => 'Management_ProController@Project_Set']);
            //财务管理
            Route::get('/financial/accounts', ['as' => 'public.accounts', 'uses' => 'FinancialController@Public_accounts']);
            Route::get('/financial/Charging', ['as' => 'charging.projects', 'uses' => 'FinancialController@Charging_projects']);
            Route::get('/financial/social', ['as' => 'social.security', 'uses' => 'FinancialController@social_security']);
            //团队管理
            Route::get('/team/store', ['as' => 'team.store', 'uses' => 'TeamController@store']);
            Route::get('/team/list', ['as' => 'team.team_list', 'uses' => 'TeamController@team_list']);
            Route::get('/team/all_members', ['as' => 'team.all_members', 'uses' => 'TeamController@all_members']);
            //报表中心
            Route::get('/report/project', ['as' => 'report.project', 'uses' => 'ReportController@project_report']);
            Route::get('/report/financial', ['as' => 'report.financial', 'uses' => 'ReportController@report_financial']);

          //内容管理

           Route::get('/artice/index', ['as' => 'artice.index', 'uses' => 'ArticeControll@index']);
           Route::get('/artice/artice_list', ['as' => 'artice.artice_list', 'uses' => 'ArticeControll@artice_list']);
           Route::get('/artice/A_fenlei', ['as' => 'artice.A_fenlei', 'uses' => 'ArticeControll@A_fenlei']);
           Route::get('/artice/Add_fenlei', ['as' => 'artice.Add_fenlei', 'uses' => 'ArticeControll@Add_fenlei']);

           Route::get('/artice/Add_slide', ['as' => 'artice.Add_slide', 'uses' => 'ArticeControll@Add_slide']);
           Route::get('/artice/slide', ['as' => 'artice.slide', 'uses' => 'ArticeControll@slide']);

           Route::get('/artice/member_list', ['as' => 'artice.member_list', 'uses' => 'ArticeControll@member_list']);
           Route::get('/artice/member', ['as' => 'artice.member', 'uses' => 'ArticeControll@member']);
           Route::get('/artice/consumption', ['as' => 'artice.consumption', 'uses' => 'ArticeControll@consumption']);
           Route::get('/artice/chongzhi', ['as' => 'artice.chongzhi', 'uses' => 'ArticeControll@chongzhi']);
           Route::get('/artice/goods', ['as' => 'artice.goods', 'uses' => 'ArticeControll@goods']);
           Route::get('/artice/goods_list', ['as' => 'artice.goods_list', 'uses' => 'ArticeControll@goods_list']);
           Route::get('/artice/Add_goods', ['as' => 'artice.Add_goods', 'uses' => 'ArticeControll@Add_goods']);
           Route::get('/artice/order', ['as' => 'artice.order', 'uses' => 'ArticeControll@order']);
           Route::get('/artice/order_XQ', ['as' => 'artice.order_XQ', 'uses' => 'ArticeControll@order_XQ']);
            Route::get('/artice/brand_list', ['as' => 'artice.brand_list', 'uses' => 'ArticeControll@brand_list']);
           Route::get('/artice/Add_brand', ['as' => 'artice.Add_brand', 'uses' => 'ArticeControll@Add_brand']);
           Route::get('/artice/Add_subtopic', ['as' => 'artice.Add_subtopic', 'uses' => 'ArticeControll@Add_subtopic']);




        });
        // 文件上传, 图片处理
        Route::post('upload', 'UploadController@index');
        Route::post('upload/encode', 'UploadController@encode');
        Route::post('upload/Cut_out', 'UploadController@Cut_out');//剪切图片
        Route::get('f/files/{s1}/{s2}/{s3}/{file}', 'ImageController@index');
        Route::get('upload/config', 'UploadController@config');
        // Api

    });
    Route::group(['prefix' => 'api', 'as' => 'api', 'namespace' => 'Api'], function () {
        Route::controller('helper', 'HelperController');

    });

});
