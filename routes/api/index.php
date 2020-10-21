<?php

/************************************************************
 *                          未登录
 ************************************************************/
Route::middleware(['sign'])->group(function () {

    // 登录、鉴权
    Route::post('/login', 'LoginController@index');

    // 首页
    Route::get('/index', 'IndexController@index');
    Route::get('/index/setting', 'IndexController@setting');
    Route::get('/index/entry', 'IndexController@entry');

    // 设计
    Route::get('/design', 'DesignController@index');
    Route::get('/design/custom', 'DesignController@custom');

    // 分类
    Route::get('/category', 'CategoryController@index');

    // 商品
    Route::get('/goods', 'GoodsController@index');
    Route::get('/goods/detail', 'GoodsController@detail');
    Route::get('/goods/poster', 'GoodsController@poster');
    Route::get('/goods/comment', 'GoodsController@comment');

    // 文章
    Route::get('/article', 'ArticleController@index');
    Route::get('/article/list', 'ArticleController@list');
    Route::get('/article/detail', 'ArticleController@detail');

    // 优惠卷列表
    Route::get('/coupon', 'CouponController@index');

    // 用户反馈
    Route::get('/feedback', 'FeedbackController@index');
    Route::post('/feedback/save', 'FeedbackController@save');

   // 协议规则
    Route::get('/rule', 'RuleController@index');
    Route::get('/rule/detail', 'RuleController@detail');

    // 积分规则
    Route::get('/points/setting', 'PointsController@setting');

    // 搜索
    Route::post('/search', 'SearchController@index');
    Route::post('/search/clear', 'SearchController@clear');
    Route::get('/search/history', 'SearchController@history');

});

/************************************************************
 *                          已登录
 ************************************************************/
Route::middleware(['sign', 'auth'])->group(function () {
    /**
     * 我的
     */
    Route::get('/mine', 'MineController@index');

    // 收藏
    Route::get('/goods/like', 'GoodsLikeController@index');
    Route::post('/goods/like/toggle', 'GoodsLikeController@toggle');
    Route::post('/goods/like/remove', 'GoodsLikeController@remove');

    // 历史
    Route::get('/goods/history', 'GoodsHistoryController@index');
    Route::post('/goods/history/remove', 'GoodsHistoryController@remove');

    // 地址
    Route::get('/address', 'AddressController@index');
    Route::get('/address/detail', 'AddressController@detail');
    Route::get('/address/default', 'AddressController@default');
    Route::post('/address/save', 'AddressController@save');
    Route::post('/address/remove', 'AddressController@remove');

    // 签到
    Route::get('/checkin', 'CheckinController@index');
    Route::post('/checkin/save', 'CheckinController@save');

    // 积分记录
    Route::get('/points', 'PointsController@index');

    /**
     * 购物车
     */
    Route::get('/cart', 'CartController@index');
    Route::get('/cart/goods', 'CartController@goods');
    Route::get('/cart/total', 'CartController@total');
    Route::post('/cart/add', 'CartController@add');
    Route::post('/cart/change', 'CartController@change');
    Route::post('/cart/clear', 'CartController@clear');
    Route::post('/cart/remove', 'CartController@remove');

    /**
     * 优惠卷
     */
    Route::get('/coupon/mine', 'CouponController@mine');
    Route::post('/coupon/receive', 'CouponController@receive');

    /**
     * 订单
     */
    Route::get('/order', 'OrderController@index');
    Route::get('/order/detail', 'OrderController@detail');
    Route::post('/order/confirm', 'OrderController@confirm');
    Route::post('/order/create', 'OrderController@create');
    Route::post('/order/close', 'OrderController@close');
    Route::post('/order/receive', 'OrderController@receive');
    Route::post('/order/remove', 'OrderController@remove');
    Route::post('/order/comment', 'OrderController@comment');
    Route::get('/order/code', 'OrderController@code');
    Route::post('/order/fetch', 'OrderController@fetch');

    /**
     * 支付
     */
    Route::post('/payment/create', 'PaymentController@create');

    /**
     * 发票
     */
    Route::get('/invoice', 'InvoiceController@index');
    Route::post('/invoice/save', 'InvoiceController@save');

    /**
     * 邀请
     */
    Route::get('/invite', 'InviteController@index');
    Route::post('/invite/poster', 'InviteController@poster');

    /**
     * 分销、提现
     */
    Route::get('/distribution', 'DistributionController@index');
    Route::get('/distribution/team', 'DistributionController@team');
    Route::get('/distribution/protocol', 'DistributionController@protocol');
    Route::post('/distribution/apply', 'DistributionController@apply');

    // 提现
    Route::get('/distribution/cash', 'DistributionController@cash');
    Route::post('/distribution/cash/apply', 'DistributionController@apply');
    Route::get('/distribution/cash/order', 'DistributionController@order');

    // 提现
    Route::get('/cash', 'CashController@index');
    Route::post('/cash/apply', 'CashController@apply');
    Route::get('/cash/order', 'CashController@order');

    /**
     * 微信
     */
    Route::post('/phone', 'WechatController@phone');
});

Route::middleware(['auth'])->group(function () {
    // 上传
    Route::post('/upload/{action}/{width?}/{height?}', 'UploadController@index');
});

Route::post('/payment/notify', 'PaymentController@notify');
