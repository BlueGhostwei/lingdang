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
        Route::get('user/HomeData', ['as' => 'user.HomeData', 'uses' => 'Apicontroller@HomeData']);//首页数据
        Route::get('user/SetUserdynamics_share', ['as' => 'user.SetUserdynamics_share', 'uses' => 'Apicontroller@SetUserdynamics_share']);//获取动态评论
        Route::get('user/share_Commented', ['as' => 'user.share_Commented', 'uses' => 'Apicontroller@share_Commented']);//获取评论详情
        Route::get('user/praise_list', ['as' => 'user.praise_list', 'uses' => 'Apicontroller@praise_list']);//我的动态点赞列表
        Route::get('user/Set_Topic', ['as' => 'user.Set_Topic', 'uses' => 'Apicontroller@Set_Topic']);//点击查看话题
        //手机.邮箱用户登录
        Route::get('user/Api_logo', ['as' => 'user.Api_logo', 'uses' => 'Apicontroller@Api_logo']);
        Route::get('user/user_login', ['as' => 'user.user_login', 'uses' => 'Bell_userController@user_login']);
        Route::get('check_user_login', "Apicontroller@check_user_login");//验证登录状态


    });
});

// 需要登录状态的路由
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Admin'], function () {


        //支付接口(支付宝)
        Route::any('alipay/payment', ['as' => 'alipay.payment', 'uses' => 'PaymentController@webNotify']);//异步通知页面路径。
        Route::any('alipay/webReturn', ['as' => 'alipay.webReturn', 'uses' => 'PaymentController@webReturn']);//同步通知页面路径。
        Route::any('alipay/mobile_alipay', ['as' => 'alipay.mobile_alipay', 'uses' => 'PaymentController@mobile_alipay']);//手机支付请求
        Route::any('alipay/alipayNotify', ['as' => 'alipay.alipayNotify', 'uses' => 'PaymentController@alipayNotify']);//手机支付异步通知
        //支付接口(微信)


        Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
        //ios登陆接口
        Route::post('user/baby_info', ['as' => 'user.baby_info', 'uses' => 'Bell_userController@baby_info']);
        Route::get('user/User_Integration', ['as' => 'user.User_Integration', 'uses' => 'Bell_userController@User_Integration']);
        Route::get('user/UserInfo', ['as' => 'user.UserInfo', 'uses' => 'Apicontroller@UserInfo']);
        Route::post('user/add_friend', ['as' => 'user.add_friend', 'uses' => 'Bell_userController@add_attention']);
        Route::get('user/daily_record', ['as' => 'user.daily_record', 'uses' => 'Apicontroller@daily_record']);//发表日记
        Route::get('user/Get_friend_list', ['as' => 'user.Get_friend_list', 'uses' => 'Bell_userController@Get_friend_list']);
        Route::post('user/Collection_diary', ['as' => 'user.Collection_diary', 'uses' => 'Apicontroller@Collection_diary']);//点赞
        Route::get('user/User_Share', ['as' => 'user.User_Share', 'uses' => 'Apicontroller@User_Share']);//好友动态评论
        Route::post('user/GetUserShare', ['as' => 'user.GetUserShare', 'uses' => 'Apicontroller@GetUserShare']);//查看动态详情
        Route::get('user/hot_topic', ['as' => 'user.hot_topic', 'uses' => 'Apicontroller@hot_topic']);//查看热门话题
        Route::get('user/api_logout', ['as' => 'user.api_logout', 'uses' => 'Apicontroller@api_logout']);//退出接口
        Route::get('user/GetUserShare_list', ['as' => 'user.GetUserShare_list', 'uses' => 'Apicontroller@GetUserShare_list']);//查看动态详情
        Route::get('user/GetFansList', ['as' => 'user.GetFansList', 'uses' => 'Apicontroller@GetFansList']);//用户粉丝列表
        Route::get('user/check_login', ['as' => 'user.check_login', 'uses' => 'Bell_userController@check_login']);//验证登录
        Route::get('user/My_dynamics', ['as' => 'user.My_dynamics', 'uses' => 'Apicontroller@My_dynamics']);//我的动态列表
        Route::get('user/Goshare_like', ['as' => 'user.Goshare_like', 'uses' => 'Apicontroller@Goshare_like']);//评论点赞接口
        Route::get('user/get_topic', ['as' => 'user.get_topic', 'uses' => 'Apicontroller@get_topic']);//话题模糊搜索
        Route::get('user/destroy_share', ['as' => 'user.destroy_share', 'uses' => 'Apicontroller@destroy_share']);//删除评论接口
        Route::get('user/destroy_bady_diary', ['as' => 'user.destroy_bady_diary', 'uses' => 'Apicontroller@destroy_bady_diary']);//删除动态接口
        Route::get('user/reminders_concern', ['as' => 'user.reminders_concern', 'uses' => 'Apicontroller@reminders_concern']);//消息提醒数量统计接口
        Route::get('user/reminders_praise', ['as' => 'user.reminders_praise', 'uses' => 'Apicontroller@reminders_praise']);//我的赞
        Route::get('user/reminders_share', ['as' => 'user.reminders_share', 'uses' => 'Apicontroller@reminders_share']);//评论我的
        Route::post('user/diary_forwarding', ['as' => 'user.diary_forwarding', 'uses' => 'Apicontroller@diary_forwarding']);//转发
        Route::get('user/bady_data', ['as' => 'user.bady_data', 'uses' => 'Bell_userController@bady_data']);//宝贝资料
        Route::get('user/bady_list', ['as' => 'user.bady_list', 'uses' => 'Bell_userController@bady_list']);//获取宝贝的资料
        Route::get('user/my_mine', ['as' => 'user.my_mine', 'uses' => 'Apicontroller@my_mine']);//转发
        Route::get('/gclass/systems', ['as' => 'gclass.systems', 'uses' => 'ClassificationController@systems']);//系统消息
        //商品分类管理
        Route::get('/gclass/index', ['as' => 'gclass.index', 'uses' => 'ClassificationController@index']);//商品一级分类列表
        Route::get('/gclass/queryclass', ['as' => 'gclass.querysclass', 'uses' => 'ClassificationController@queryclass']);//获取商品的信息
        Route::get('/gclass/commodity', ['as' => 'gclass.commodity', 'uses' => 'ClassificationController@commodity']);//获取商品详情信息
        Route::get('goods/jsfengoods_list', ['as' => 'goods.jsfengoods_list', 'uses' => 'SortController@jsfengoods_list']);
        // 需要登录状态和权限控制的路由
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
        Route::get('/artice/artice_detailed', ['as' => 'artice.artice_detailed', 'uses' => 'ArticeControll@artice_detailed']);//文章详情信息
        Route::get('/artice/artice_home', ['as' => 'artice.artice_home', 'uses' => 'ArticeControll@artice_home']);//首页信息
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
        //商品管理
        Route::get('goods/goods_list', ['as' => 'goods.goods_list', 'uses' => 'GoodsController@goods_list']);//商品列表
        Route::get('goods/SelGoodStand', ['as' => 'goods.SelGoodStand', 'uses' => 'GoodsController@SelGoodStand']); //查看商品规格
        Route::get('/goods/show/{id}', ['as' => 'goods.show', 'uses' => 'GoodsController@show']);//商品详情
        Route::post('/goods/update', ['as' => 'goods.update', 'uses' => 'GoodsController@update']);//商品更新
        Route::get('/goods/Add_goods', ['as' => 'goods.Add_goods', 'uses' => 'GoodsController@Add_goods']);//添加商品
        Route::post('artice/SaveAttributes', ['as' => 'artice.SaveAttributes', 'uses' => 'ArticeControll@SaveAttributes']);//添加商品分类属性
        Route::post('artice/ProductFormat', ['as' => 'artice.ProductFormat', 'uses' => 'ArticeControll@ProductFormat']);//保存商品分类规格
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
        Route::post('artice/flgl', ['as' => 'artice.flgl', 'uses' => 'ArticeControll@flgl']);//删除分类
        Route::post('sort/update/{id}', ['as' => 'sort.update', 'uses' => 'SortController@update']);//更新商品分类
        Route::post('sort/storeBrand', ['as' => 'sort.storeBrand', 'uses' => 'SortController@storeBrand']);//添加分类品牌
        Route::get('/goods/collection', ['as' => 'goods.collection', 'uses' => 'GoodsController@collection']);//商品收藏
        Route::get('/goods/colist', ['as' => 'goods.colist', 'uses' => 'GoodsController@colist']);//商品收藏列表
        Route::get('/goods/GoodsCouponList', ['as' => 'goods.GoodsCouponList', 'uses' => 'GoodsController@GoodsCouponList']);//商品优惠券列表
        Route::get('/goods/GoodsCoupon', ['as' => 'goods.GoodsCoupon', 'uses' => 'GoodsController@GoodsCoupon']);//商品优惠券添加
        Route::post('goods/GoodsCouponSave', ['as' => 'goods.GoodsCouponSave', 'uses' => 'GoodsController@GoodsCouponSave']);//创建优惠券
        Route::get('goods/coupon_show', ['as' => 'goods.coupon_show', 'uses' => 'GoodsController@coupon_show']);
        Route::post('goods/GoodsCouponUpdate', ['as' => 'goods.GoodsCouponUpdate', 'uses' => 'GoodsController@GoodsCouponUpdate']);
        Route::get('goods/coupon_dele', ['as' => 'goods.coupon_dele', 'uses' => 'GoodsController@coupon_dele']);
        //购物车
        Route::get('goods/shoplist', ['as' => 'goods.shoplist', 'uses' => 'GoodsController@shoplist']);//商品列表
        Route::get('goods/delshop', ['as' => 'goods.delshop', 'uses' => 'GoodsController@delshop']);//删除购物车
        Route::get('goods/shopping', ['as' => 'goods.shopping', 'uses' => 'GoodsController@shopping']);//添加购物车
        //地址管理
        Route::get('/gclass/address', ['as' => 'gclass.address', 'uses' => 'ClassificationController@address']);//添加地址管理
        Route::get('/gclass/ressdel', ['as' => 'gclass.ressdel', 'uses' => 'ClassificationController@ressdel']);//删除地址管理
        Route::get('/gclass/resslist', ['as' => 'gclass.resslist', 'uses' => 'ClassificationController@resslist']);//地址管理列表
        Route::get('/gclass/gressupdate', ['as' => 'gclass.gressupdate', 'uses' => 'ClassificationController@gressupdate']);//地址管理列表
        Route::post('/gclass/ressupdate', ['as' => 'gclsaa.ressupdate', 'uses' => 'ClassificationController@ressupdate']);//地址管理更新
        //积分商城
        Route::get('goods/PointsMall', ['as' => 'goods.PointsMall', 'uses' => 'GoodsController@PointsMall']);//积分商城列表
        Route::get('goods/FreeChargeGoods', ['as' => 'goods.FreeChargeGoods', 'uses' => 'GoodsController@FreeChargeGoods']);//免单活动商城列表
        Route::get('order/GenerateOrder', ['as' => 'order.GenerateOrder', 'uses' => 'OrderController@GenerateOrder']);//生成订单
        Route::get('order/OrderList', ['as' => 'order.OrderList', 'uses' => 'OrderController@OrderList']);//生成订单列表
        Route::get('order/order_infomation', ['as' => 'order.order_infomation', 'uses' => 'OrderController@order_infomation']);//订单详情（含商品）
        Route::get('order/destroy', ['as' => 'order.destroy', 'uses' => 'OrderController@destroy']);//删除订单

        Route::get('artice/Add_subtopic/{id}', ['as' => 'artice.Add_subtopic', 'uses' => 'ArticeControll@Add_subtopic']);
        Route::post('goods/set_brand_sort', ['as' => 'goods.set_brand_sort', 'uses' => 'GoodsController@set_brand_sort']);
        Route::post('goods/store', 'GoodsController@store');
        Route::get('artice/M_properties', ['as' => 'artice.M_properties', 'uses' => 'SortController@M_properties']);
        Route::get('artice/Add_specifications', ['as' => 'artice.Add_specifications', 'uses' => 'SortController@Add_specifications']);
        Route::get('artice/Add_properties', ['as' => 'artice.Add_properties', 'uses' => 'SortController@Add_properties']);
        Route::get('artice/Add_moxing', ['as' => 'artice.Add_moxing', 'uses' => 'SortController@Add_moxing']);

        Route::get('artice/B_dingdan_completelist', ['as' => 'artice.B_dingdan_completelist', 'uses' => 'SortController@B_dingdan_completelist']);
        Route::get('artice/B_dingdan_deliverylist', ['as' => 'artice.B_dingdan_deliverylist', 'uses' => 'SortController@B_dingdan_deliverylist']);
        Route::get('artice/B_dingdan_Nodeliverylist', ['as' => 'artice.B_dingdan_Nodeliverylist', 'uses' => 'SortController@B_dingdan_Nodeliverylist']);
        Route::get('artice/B_dingdan_backlist', ['as' => 'artice.B_dingdan_backlist', 'uses' => 'SortController@B_dingdan_backlist']);
        Route::get('artice/B_dingdan_read', ['as' => 'artice.B_dingdan_read', 'uses' => 'SortController@B_dingdan_read']);
        Route::get('artice/B_backlist_read', ['as' => 'artice.B_backlist_read', 'uses' => 'SortController@B_backlist_read']);


        //文件上传, 图片处理
        Route::post('upload', 'UploadController@index');
        Route::post('Pic_upload', ['as' => 'user.Pic_upload', 'uses' => 'PIcUploadController@index']);
        Route::post('upload/encode', 'UploadController@encode');
        Route::post('upload/Cut_out', 'UploadController@Cut_out');//剪切图片
        Route::get('f/files/{s1}/{s2}/{s3}/{file}', 'ImageController@index');
        Route::get('upload/config', 'UploadController@config');
        Route::get('upload/base64imgsave', 'UploadController@base64imgsave');
        Route::post('Pic_upload', ['as' => 'user.Pic_upload', 'uses' => 'PIcUploadController@index']);
        // iosapi 接口
    });
    Route::group(['prefix' => 'api', 'as' => 'api', 'namespace' => 'Api'], function () {
        Route::controller('helper', 'HelperController');

    });

});
