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
        Route::post('user/sign_up', ['as' => 'user.sign_up', 'uses' => 'Bell_userController@sign_up']);
        Route::get('Admin/user/login', ['as' => 'user.login', 'uses' => 'UserController@getLogin']);
        Route::post('Admin/user/login', 'UserController@postLogin');
        Route::get('/user/register', ['as' => 'user.register', 'uses' => 'UserController@getRegister']);
        Route::post('/user/register', 'UserController@postRegister');
        Route::get('/user/register/step2', ['as' => 'user.register.step2', 'uses' => 'UserController@getRegisterStep2']);
        Route::post('/user/register/step2', 'UserController@postRegisterStep2');
        Route::get('/user/register/step3', ['as' => 'user.register.step3', 'uses' => 'UserController@getRegisterStep3']);
        Route::post('/user/register/step3', 'UserController@postRegisterStep3');
        // 找回密码
        Route::post('user/findPass', ['as' => 'user.findPass', 'uses' => 'Bell_userController@findPass']);
        Route::get('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
        Route::post('password/email', 'Auth\PasswordController@postEmail');
        Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
        Route::post('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);
        //ios
        Route::get('user/Get_Token', 'UserController@GEt_token');
        Route::post('user/send_sms', ['as' => 'user.send_sms', 'uses' => 'Bell_userController@Send_sms']);
        //手机.邮箱用户登录
        Route::post('user/user_login', 'Bell_userController@user_login');
    });
});

// 需要登录状态的路由
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Admin'], function () {
        Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
        //ios登陆接口
        Route::post('user/baby_info', ['as' => 'user.baby_info', 'uses' => 'Bell_userController@baby_info']);
        Route::get('user/User_Integration', ['as' => 'user.User_Integration', 'uses' => 'Bell_userController@User_Integration']);
        Route::get('user/Api_logo', ['as' => 'user.Api_logo', 'uses' => 'Apicontroller@Api_logo']);
        Route::get('user/add_friend', ['as' => 'user.add_friend', 'uses' => 'Bell_userController@add_friend']);
        Route::get('user/daily_record', ['as' => 'user.daily_record', 'uses' => 'Apicontroller@daily_record']);
        Route::get('user/Get_friend_list', ['as' => 'user.Get_friend_list', 'uses' => 'Bell_userController@Get_friend_list']);
        Route::get('user/Collection_diary', ['as' => 'user.Collection_diary', 'uses' => 'Bell_userController@Collection_diary']);//点赞
        Route::get('user/User_Share', ['as' => 'user.User_Share', 'uses' => 'Apicontroller@User_Share']);//保存好友评论
        Route::get('user/GetUserShare_list', ['as' => 'user.GetUserShare_list', 'uses' => 'Apicontroller@GetUserShare_list']);//查看动态详情


        // 需要登录状态和权限控制的路由
        Route::get('admin/system/logs', ['as' => 'system.logs', 'uses' => 'SystemController@logs']);
        Route::get('admin/system/action', ['as' => 'system.action', 'uses' => 'SystemController@action']);
        Route::get('admin/system/login-history', ['as' => 'system.login-history', 'uses' => 'SystemController@loginHistory']);
        // 权限配置
        Route::any('/admin/acl/resource', ['as' => 'admin.acl.resource.index', 'uses' => 'AclResourceController@index']);
        Route::any('/admin/acl/role', ['as' => 'admin.role.index', 'uses' => 'AclRoleController@index']);
        Route::get('/acl/role/user_edit/{id}', ['as' => 'acl.role.user_edit', 'uses' => 'AclRoleController@user_edit']);
        Route::any('/acl/role/user_role_update/{id}', ['as' => 'acl.role.user_role_update', 'uses' => 'AclRoleController@user_role_update']);

        Route::resource('/acl/resource', 'AclResourceControll   er');
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
        Route::get('/artice/artice_list', ['as' => 'artice.artice_list', 'uses' => 'ArticeControll@artice_list']);//文章列表
        Route::post('/artice/artice_list', 'ArticeControll@artice_list');//文章列表
        Route::get('/artice/artice_list_show/{id}', ['as' => 'artice.artice_list_show', 'uses' => 'ArticeControll@artice_list_show']);//文章查看
        Route::post('/artice/artice_list_update', ['as' => 'artice.artice_list_update', 'uses' => 'ArticeControll@artice_list_update']);//文章更新
        Route::post('/artice/artice_list_destroy', ['as' => 'artice.artice_list_destroy', 'uses' => 'ArticeControll@artice_list_destroy']);//删除文章
        Route::get('/artice/A_fenlei', ['as' => 'artice.A_fenlei', 'uses' => 'ArticeControll@A_fenlei']);
        Route::get('/artice/Add_fenlei', ['as' => 'artice.Add_fenlei', 'uses' => 'ArticeControll@Add_fenlei']);//添加文章分类页
        Route::post('/artice/save_fenlei', ['as' => 'artice.save_fenlei', 'uses' => 'ArticeControll@save_fenlei']);//保存文章分类
        Route::get('/support/show/{id}', ['as' => 'support.show', 'uses' => 'ArticeControll@support_show']);//查看文章分类
        Route::post('/support/update', ['as' => 'support.update', 'uses' => 'ArticeControll@support_update']);//更新文章分类
        Route::post('/artice/store_actice', ['as' => 'support.store_actice', 'uses' => 'ArticeControll@store_actice']);//添加文章

        //轮播图管理
        Route::get('/artice/Add_slide', ['as' => 'artice.Add_slide', 'uses' => 'ArticeControll@Add_slide']);//添加幻灯片图片
        Route::post('/artice/save_slide', ['as' => 'artice.save_slide', 'uses' => 'ArticeControll@save_slide']);//保存幻灯片图片
        Route::get('/photo/slide', ['as' => 'photo.slide', 'uses' => 'ArticeControll@slide']);//幻灯片列表
        Route::get('/photo/show/{id}', ['as' => 'photo.show', 'uses' => 'ArticeControll@show']);//轮播图查看
        Route::post('/photo/update', ['as' => 'photo.update', 'uses' => 'ArticeControll@update']);//轮播图修改
        Route::post('/photo/destroy', ['as' => 'photo.destroy', 'uses' => 'ArticeControll@destroy']);//轮播图删除
        Route::get('/Bells/member_list', ['as' => 'Bells.member_list', 'uses' => 'UserController@member_list']);
        Route::get('/artice/member', ['as' => 'artice.member', 'uses' => 'ArticeControll@member']);
        Route::get('/artice/consumption', ['as' => 'artice.consumption', 'uses' => 'ArticeControll@consumption']);
        Route::get('/artice/chongzhi', ['as' => 'artice.chongzhi', 'uses' => 'ArticeControll@chongzhi']);
        Route::get('/artice/goods', ['as' => 'artice.goods', 'uses' => 'ArticeControll@goods']);
        Route::get('goods/goods_list', ['as' => 'goods.goods_list', 'uses' => 'GoodsController@goods_list']);//商品列表
        Route::get('/goods/show/{id}', ['as' => 'goods.show', 'uses' => 'GoodsController@show']);//商品详情
        Route::post('/goods/update', ['as' => 'goods.update', 'uses' => 'GoodsController@update']);//商品更新
        Route::get('/goods/Add_goods', ['as' => 'goods.Add_goods', 'uses' => 'GoodsController@Add_goods']);//添加商品
        Route::get('/artice/order', ['as' => 'artice.order', 'uses' => 'ArticeControll@order']);
        Route::get('/artice/order_XQ', ['as' => 'artice.order_XQ', 'uses' => 'ArticeControll@order_XQ']);
        Route::get('/artice/brand_list', ['as' => 'brand.brand_list', 'uses' => 'ArticeControll@brand_list']);//品牌列表
        Route::get('/artice/brand_edit/{id}', ['as' => 'artice.brand_edit', 'uses' => 'ArticeControll@brand_edit']);//品牌查看
        Route::post('/artice/brand_update', ['as' => 'artice.brand_update', 'uses' => 'ArticeControll@brand_update']);//品牌更新
        Route::post('/artice/Brand_Dele', ['as' => 'artice.Brand_Dele', 'uses' => 'ArticeControll@Brand_Dele']);//品牌更新
        Route::get('/artice/Add_brand', ['as' => 'artice.Add_brand', 'uses' => 'SortController@index']);//添加商品移动分类
        Route::post('sort/store', ['as' => 'sort.store', 'uses' => 'SortController@store']);//添加商品分类
        Route::get('sort/edit/{id}', ['as' => 'sort.edit', 'uses' => 'SortController@edit']);//修改分类
        Route::post('sort/destroy', ['as' => 'sort.destroy', 'uses' => 'SortController@destroy']);//删除分类
        Route::post('sort/update/{id}', ['as' => 'sort.update', 'uses' => 'SortController@update']);//更新商品分类
        Route::post('sort/storeBrand', ['as' => 'sort.storeBrand', 'uses' => 'SortController@storeBrand']);//添加分类品牌
        Route::get('artice/Add_subtopic/{id}', ['as' => 'artice.Add_subtopic', 'uses' => 'ArticeControll@Add_subtopic']);
        Route::post('goods/set_brand_sort', ['as' => 'goods.set_brand_sort', 'uses' => 'GoodsController@set_brand_sort']);
        Route::post('goods/store', 'GoodsController@store');
        //文件上传, 图片处理
        Route::post('upload', 'UploadController@index');
        Route::post('upload/encode', 'UploadController@encode');
        Route::post('upload/Cut_out', 'UploadController@Cut_out');//剪切图片
        Route::get('f/files/{s1}/{s2}/{s3}/{file}', 'ImageController@index');
        Route::get('upload/config', 'UploadController@config');
        Route::get('upload/base64imgsave', 'UploadController@base64imgsave');
        // iosapi 接口
    });
    Route::group(['prefix' => 'api', 'as' => 'api', 'namespace' => 'Api'], function () {
        Route::controller('helper', 'HelperController');

    });

});
