<?php

/************************************************************
 *                              系统
 ************************************************************/
Route::namespace('System')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 账号
    Route::get('/admin', 'AdminController@index')->name('admin.index');
    Route::get('/admin/add', 'AdminController@add')->name('admin.save');
    Route::post('/admin/add.do', 'AdminController@doAdd')->name('admin.save');
    Route::get('/admin/edit', 'AdminController@edit')->name('admin.save');
    Route::post('/admin/edit.do', 'AdminController@doEdit')->name('admin.save');
    Route::post('/admin/remove.do', 'AdminController@doRemove')->name('admin.remove');

    // 模块
    Route::get('/module', 'ModuleController@index')->name('module.index');
    Route::get('/module/add', 'ModuleController@add')->name('module.save');
    Route::post('/module/add.do', 'ModuleController@doAdd')->name('module.save');
    Route::get('/module/edit', 'ModuleController@edit')->name('module.save');
    Route::post('/module/edit.do', 'ModuleController@doEdit')->name('module.save');
    Route::get('/module/sort', 'ModuleController@sort')->name('module.save');
    Route::post('/module/sort.do', 'ModuleController@doSort')->name('module.save');
    Route::post('/module/remove.do', 'ModuleController@doRemove')->name('module.remove');

    // 角色
    Route::get('/role', 'RoleController@index')->name('role.index');
    Route::get('/role/add', 'RoleController@add')->name('role.save');
    Route::post('/role/add.do', 'RoleController@doAdd')->name('role.save');
    Route::get('/role/edit', 'RoleController@edit')->name('role.save');
    Route::post('/role/edit.do', 'RoleController@doEdit')->name('role.save');
    Route::post('/role/remove.do', 'RoleController@doRemove')->name('role.remove');

    // 日志
    Route::get('/log', 'AccountLogController@index')->name('log.index');
    Route::post('/log/remove.do', 'AccountLogController@doRemove')->name('log.remove');
});

/************************************************************
 *                              设置
 ************************************************************/
Route::namespace('Setting')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 基础
    Route::get('/setting', 'SettingController@index')->name('setting.index');
    Route::post('/setting/save', 'SettingController@save')->name('setting.save');
    Route::post('/setting/flush', 'SettingController@flush')->name('setting.save');

    // 打印机
    Route::get('/printer', 'PrinterController@index')->name('setting.save');
    Route::get('/printer/add', 'PrinterController@add')->name('setting.save');
    Route::post('/printer/add.do', 'PrinterController@doAdd')->name('setting.save');
    Route::get('/printer/edit', 'PrinterController@edit')->name('setting.save');
    Route::post('/printer/edit.do', 'PrinterController@doEdit')->name('setting.save');
    Route::post('/printer/status.do', 'PrinterController@doStatus')->name('setting.save');
    Route::post('/printer/remove.do', 'PrinterController@doRemove')->name('setting.save');

    // 反馈分类
    Route::get('/feedback/category', 'FeedbackCategoryController@index')->name('setting.save');
    Route::get('/feedback/category/add', 'FeedbackCategoryController@add')->name('setting.save');
    Route::post('/feedback/category/add.do', 'FeedbackCategoryController@doAdd')->name('setting.save');
    Route::get('/feedback/category/edit', 'FeedbackCategoryController@edit')->name('setting.save');
    Route::post('/feedback/category/edit.do', 'FeedbackCategoryController@doEdit')->name('setting.save');
    Route::post('/feedback/category/remove.do', 'FeedbackCategoryController@doRemove')->name('setting.save');

    // 协议规则
    Route::get('/rule', 'RuleController@index')->name('setting.save');
    Route::get('/rule/add', 'RuleController@add')->name('setting.save');
    Route::post('/rule/add.do', 'RuleController@doAdd')->name('setting.save');
    Route::get('/rule/edit', 'RuleController@edit')->name('setting.save');
    Route::post('/rule/edit.do', 'RuleController@doEdit')->name('setting.save');
    Route::post('/rule/remove.do', 'RuleController@doRemove')->name('setting.save');

    // 快递公司
    Route::get('/logistics/company', 'ExpressController@index')->name('setting.save');
    Route::get('/logistics/company/add', 'ExpressController@add')->name('setting.save');
    Route::post('/logistics/company/add.do', 'ExpressController@doAdd')->name('setting.save');
    Route::get('/logistics/company/edit', 'ExpressController@edit')->name('setting.save');
    Route::post('/logistics/company/edit.do', 'ExpressController@doEdit')->name('setting.save');
    Route::post('/logistics/company/remove.do', 'ExpressController@doRemove')->name('setting.save');

    // 快递运费模板
    Route::get('/logistics/template/express', 'ExpressTemplateController@index')->name('setting.save');
    Route::get('/logistics/template/express/add', 'ExpressTemplateController@add')->name('setting.save');
    Route::post('/logistics/template/express/add.do', 'ExpressTemplateController@doAdd')->name('setting.save');
    Route::get('/logistics/template/express/edit', 'ExpressTemplateController@edit')->name('setting.save');
    Route::post('/logistics/template/express/edit.do', 'ExpressTemplateController@doEdit')->name('setting.save');
    Route::post('/logistics/template/express/remove.do', 'ExpressTemplateController@doRemove')->name('setting.save');
    Route::get('/logistics/template/express/all', 'ExpressTemplateController@all')->name('setting.save');

    // 同城快递运费模板
    Route::get('/logistics/template/local', 'LocalTemplateController@index')->name('setting.save');
    Route::get('/logistics/template/local/add', 'LocalTemplateController@add')->name('setting.save');
    Route::post('/logistics/template/local/add.do', 'LocalTemplateController@doAdd')->name('setting.save');
    Route::get('/logistics/template/local/edit', 'LocalTemplateController@edit')->name('setting.save');
    Route::post('/logistics/template/local/edit.do', 'LocalTemplateController@doEdit')->name('setting.save');
    Route::post('/logistics/template/local/remove.do', 'LocalTemplateController@doRemove')->name('setting.save');
    Route::get('/logistics/template/local/all', 'LocalTemplateController@all')->name('setting.save');
});

/************************************************************
 *                              用户
 ************************************************************/
Route::namespace('User')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 用户
    Route::get('/user', 'UserController@index')->name('user.index');

    // 详细
    Route::get('/user/detail', 'UserController@detail')->name('user.detail');
    Route::get('/user/detail/order', 'UserController@detailOrder')->name('user.detail');
    Route::get('/user/detail/coupon', 'UserController@detailCoupon')->name('user.detail');
    Route::get('/user/detail/points', 'UserController@detailPoints')->name('user.detail');
    Route::get('/user/detail/cart', 'UserController@detailCart')->name('user.detail');
    Route::get('/user/detail/like', 'UserController@detailLike')->name('user.detail');
    Route::get('/user/detail/bonus', 'UserController@detailBonus')->name('user.detail');

    // 编辑
    Route::get('/user/edit/tag', 'UserController@editTag')->name('user.edit');
    Route::post('/user/edit/tag.do', 'UserController@doEditTag')->name('user.edit');
    Route::get('/user/edit/points', 'UserController@editPoints')->name('user.edit');
    Route::post('/user/edit/points.do', 'UserController@doEditPoints')->name('user.edit');
    Route::get('/user/edit/bonus', 'UserController@editBonus')->name('user.edit');
    Route::post('/user/edit/bonus.do', 'UserController@doEditBonus')->name('user.edit');

    // 标签
    Route::get('/user/tag', 'TagController@index')->name('user/tag.index');
    Route::get('/user/tag/add', 'TagController@add')->name('user/tag.save');
    Route::post('/user/tag/add.do', 'TagController@doAdd')->name('user/tag.save');
    Route::get('/user/tag/edit', 'TagController@edit')->name('user/tag.save');
    Route::post('/user/tag/edit.do', 'TagController@doEdit')->name('user/tag.save');
    Route::post('/user/tag/remove.do', 'TagController@doRemove')->name('user/tag.remove');

    //反馈
    Route::get('/user/feedback', 'FeedbackController@init')->name('user/feedback.index');
    Route::get('/user/feedback/list', 'FeedbackController@index')->name('user/feedback.index');
    Route::post('/user/feedback/remove.do', 'FeedbackController@doRemove')->name('user/feedback.remove');
});

/************************************************************
 *                             店铺
 ************************************************************/
Route::namespace('Shop')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 装修
    Route::get('/shop/design', 'DesignController@index')->name('shop/design.index');
    Route::post('/shop/design/save.do', 'DesignController@doSave')->name('shop/design.save');
    Route::get('/shop/design/goods/category', 'DesignController@goodsCategory')->name('shop/design.index');
    Route::get('/shop/design/goods/group', 'DesignController@goodsGroup')->name('shop/design.index');

    // 页面
    Route::get('/shop/page', 'PageController@index')->name('shop/page.index');
    Route::get('/shop/page/add', 'PageController@add')->name('shop/page.save');
    Route::post('/shop/page/add.do', 'PageController@doAdd')->name('shop/page.save');
    Route::get('/shop/page/edit', 'PageController@edit')->name('shop/page.save');
    Route::post('/shop/page/edit.do', 'PageController@doEdit')->name('shop/page.save');
    Route::get('/shop/page/design', 'PageController@design')->name('shop/page.save');
    Route::post('/shop/page/design.do', 'PageController@doDesign')->name('shop/page.save');
    Route::post('/shop/page/status.do', 'PageController@doStatus')->name('shop/page.save');
    Route::post('/shop/page/remove.do', 'PageController@doRemove')->name('shop/page.remove');

    // 门店
    Route::get('/shop/store', 'StoreController@index')->name('shop/store.index');
    Route::get('/shop/store/add', 'StoreController@add')->name('shop/store.save');
    Route::post('/shop/store/add.do', 'StoreController@doAdd')->name('shop/store.save');
    Route::get('/shop/store/edit', 'StoreController@edit')->name('shop/store.save');
    Route::post('/shop/store/edit.do', 'StoreController@doEdit')->name('shop/store.save');
    Route::post('/shop/store/status.do', 'StoreController@doStatus')->name('shop/store.save');
    Route::post('/shop/store/remove.do', 'StoreController@doRemove')->name('shop/store.remove');

    // 自提点
    Route::get('/shop/address', 'StoreAddressController@index')->name('shop/address.index');
    Route::get('/shop/address/add', 'StoreAddressController@add')->name('shop/address.save');
    Route::post('/shop/address/add.do', 'StoreAddressController@doAdd')->name('shop/address.save');
    Route::get('/shop/address/edit', 'StoreAddressController@edit')->name('shop/address.save');
    Route::post('/shop/address/edit.do', 'StoreAddressController@doEdit')->name('shop/address.save');
    Route::post('/shop/address/status.do', 'StoreAddressController@doStatus')->name('shop/address.save');
    Route::post('/shop/address/remove.do', 'StoreAddressController@doRemove')->name('shop/address.remove');

    // 员工
    Route::get('/shop/employee', 'StoreEmployeeController@index')->name('shop/employee.index');
    Route::get('/shop/employee/add', 'StoreEmployeeController@add')->name('shop/employee.save');
    Route::post('/shop/employee/add.do', 'StoreEmployeeController@doAdd')->name('shop/employee.save');
    Route::get('/shop/employee/edit', 'StoreEmployeeController@edit')->name('shop/employee.save');
    Route::post('/shop/employee/edit.do', 'StoreEmployeeController@doEdit')->name('shop/employee.save');
    Route::post('/shop/employee/status.do', 'StoreEmployeeController@doStatus')->name('shop/employee.save');
    Route::post('/shop/employee/remove.do', 'StoreEmployeeController@doRemove')->name('shop/employee.remove');
});

/************************************************************
 *                              商品
 ************************************************************/
Route::namespace('Goods')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 商品
    Route::get('/goods', 'GoodsController@index')->name('goods.index');
    Route::get('/goods/list', 'GoodsController@list')->name('goods.index');
    Route::get('/goods/add', 'GoodsController@add')->name('goods.save');
    Route::post('/goods/add.do', 'GoodsController@doAdd')->name('goods.save');
    Route::get('/goods/edit', 'GoodsController@edit')->name('goods.save');
    Route::post('/goods/edit.do', 'GoodsController@doEdit')->name('goods.save');
    Route::get('/goods/content', 'GoodsController@content')->name('goods.save');
    Route::post('/goods/content.do', 'GoodsController@doContent')->name('goods.save');
    Route::get('/goods/sale', 'GoodsController@sale')->name('goods.save');
    Route::post('/goods/sale.do', 'GoodsController@doSale')->name('goods.save');
    Route::get('/goods/logistics', 'GoodsController@logistics')->name('goods.save');
    Route::post('/goods/logistics.do', 'GoodsController@doLogistics')->name('goods.save');
    Route::get('/goods/other', 'GoodsController@other')->name('goods.save');
    Route::post('/goods/other.do', 'GoodsController@doOther')->name('goods.save');
    Route::post('/goods/status.do', 'GoodsController@doStatus')->name('goods.save');
    Route::post('/goods/remove.do', 'GoodsController@doRemove')->name('goods.remove');

    // 商品分类
    Route::get('/goods/category', 'CategoryController@index')->name('goods/category.index');
    Route::get('/goods/category/add', 'CategoryController@add')->name('goods/category.save');
    Route::post('/goods/category/add.do', 'CategoryController@doAdd')->name('goods/category.save');
    Route::get('/goods/category/edit', 'CategoryController@edit')->name('goods/category.save');
    Route::post('/goods/category/edit.do', 'CategoryController@doEdit')->name('goods/category.save');
    Route::get('/goods/category/sort', 'CategoryController@sort')->name('goods/category.save');
    Route::post('/goods/category/sort.do', 'CategoryController@doSort')->name('goods/category.save');
    Route::post('/goods/category/status.do', 'CategoryController@doStatus')->name('goods/category.save');
    Route::post('/goods/category/remove.do', 'CategoryController@doRemove')->name('goods/category.remove');

    // 商品分组
    Route::get('/goods/group', 'GroupController@index')->name('goods/group.index');
    Route::get('/goods/group/add', 'GroupController@add')->name('goods/group.save');
    Route::post('/goods/group/add.do', 'GroupController@doAdd')->name('goods/group.save');
    Route::get('/goods/group/edit', 'GroupController@edit')->name('goods/group.save');
    Route::post('/goods/group/edit.do', 'GroupController@doEdit')->name('goods/group.save');
    Route::post('/goods/group/status.do', 'GroupController@doStatus')->name('goods/group.save');
    Route::post('/goods/group/remove.do', 'GroupController@doRemove')->name('goods/group.remove');

    // 商品规格
    Route::get('/goods/spec', 'SpecController@index')->name('goods/spec.index');
    Route::get('/goods/spec/add', 'SpecController@add')->name('goods/spec.save');
    Route::post('/goods/spec/add.do', 'SpecController@doAdd')->name('goods/spec.save');
    Route::get('/goods/spec/edit', 'SpecController@edit')->name('goods/spec.save');
    Route::post('/goods/spec/edit.do', 'SpecController@doEdit')->name('goods/spec.save');
    Route::post('/goods/spec/remove.do', 'SpecController@doRemove')->name('goods/spec.remove');
    Route::post('/goods/spec/value/add.do', 'SpecController@doAddValue')->name('goods/spec.save');
    Route::post('/goods/spec/value/remove.do', 'SpecController@doRemoveValue')->name('goods/spec.remove');

    // 商品支持
    Route::get('/goods/support', 'SupportController@index')->name('goods/support.index');
    Route::get('/goods/support/add', 'SupportController@add')->name('goods/support.save');
    Route::post('/goods/support/add.do', 'SupportController@doAdd')->name('goods/support.save');
    Route::get('/goods/support/edit', 'SupportController@edit')->name('goods/support.save');
    Route::post('/goods/support/edit.do', 'SupportController@doEdit')->name('goods/support.save');
    Route::post('/goods/support/status.do', 'SupportController@doStatus')->name('goods/support.save');
    Route::post('/goods/support/remove.do', 'SupportController@doRemove')->name('goods/support.remove');

    // 单位
    Route::get('/goods/unit', 'UnitController@index')->name('goods/unit.index');
    Route::get('/goods/unit/add', 'UnitController@add')->name('goods/unit.save');
    Route::post('/goods/unit/add.do', 'UnitController@doAdd')->name('goods/unit.save');
    Route::get('/goods/unit/edit', 'UnitController@edit')->name('goods/unit.save');
    Route::post('/goods/unit/edit.do', 'UnitController@doEdit')->name('goods/unit.save');
    Route::post('/goods/unit/remove.do', 'UnitController@doRemove')->name('goods/unit.remove');
});

/************************************************************
 *                             订单
 ************************************************************/
Route::namespace('Order')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    //普通订单
    Route::get('/order', 'OrderController@index')->name('order.index');
    Route::get('/order/detail', 'OrderController@detail')->name('order.detail');
    Route::get('/order/shipment', 'OrderController@shipment')->name('order.shipment');
    Route::post('/order/shipment.do', 'OrderController@doShipment')->name('order.shipment');
    Route::post('/order/prints.do', 'OrderController@doPrints')->name('order.prints');

    // 发票
    Route::get('/order/invoice', 'OrderInvoiceController@index')->name('order/invoice.index');
    Route::get('/order/invoice/issue', 'OrderInvoiceController@issue')->name('order/invoice.issue');
    Route::post('/order/invoice/issue.do', 'OrderInvoiceController@doIssue')->name('order/invoice.issue');

    // 评论
    Route::get('/order/comment', 'OrderCommentController@index')->name('order/comment.index');
    Route::post('/order/comment/status.do', 'OrderCommentController@doStatus')->name('order/comment.reply');
    Route::post('/order/comment/reply.do', 'OrderCommentController@doReply')->name('order/comment.reply');
    Route::post('/order/comment/remove.do', 'OrderCommentController@doRemove')->name('order/comment.remove');
});

/************************************************************
 *                             营销
 ************************************************************/
Route::namespace('Market')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 优惠卷
    Route::get('/market/coupon', 'CouponController@index')->name('market/coupon.index');
    Route::get('/market/coupon/add', 'CouponController@add')->name('market/coupon.save');
    Route::post('/market/coupon/add.do', 'CouponController@doAdd')->name('market/coupon.save');
    Route::get('/market/coupon/edit', 'CouponController@edit')->name('market/coupon.save');
    Route::post('/market/coupon/edit.do', 'CouponController@doEdit')->name('market/coupon.save');
    Route::post('/market/coupon/status.do', 'CouponController@doStatus')->name('market/coupon.save');
    Route::post('/market/coupon/issue.do', 'CouponController@doIssue')->name('market/coupon.save');
    Route::post('/market/coupon/remove.do', 'CouponController@doRemove')->name('market/coupon.remove');

    // 优惠卷领取
    Route::get('/market/coupon/receive', 'CouponReceiveController@index')->name('market/coupon/receive.index');
    Route::post('/market/coupon/receive/remove.do', 'CouponReceiveController@doRemove')->name('market/coupon/receive.remove');

    // 分销商
    Route::get('/market/distribution', 'DistributionController@index')->name('market/distribution.index');
    Route::get('/market/distribution/auth', 'DistributionController@auth')->name('market/distribution.auth');
    Route::post('/market/distribution/auth.do', 'DistributionController@doAuth')->name('market/distribution.auth');
});

/************************************************************
 *                          财务
 ************************************************************/
Route::namespace('Finance')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 支付流水
    Route::get('/finance/payment', 'PaymentController@index')->name('finance/payment.index');
    Route::get('/finance/payment/detail', 'PaymentController@detail')->name('finance/payment.index');

    // 提现
    Route::get('/finance/cash', 'CashController@index')->name('finance/cash.index');
    Route::get('/finance/cash/audit', 'CashController@audit')->name('finance/cash.audit');
    Route::post('/finance/cash/audit.do', 'CashController@doAudit')->name('finance/cash.audit');
});

/************************************************************
 *                             文章
 ************************************************************/
Route::namespace('Article')->middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    // 文章
    Route::get('/article', 'ArticleController@index')->name('article.index');
    Route::get('/article/add', 'ArticleController@add')->name('article.save');
    Route::post('/article/add.do', 'ArticleController@doAdd')->name('article.save');
    Route::get('/article/edit', 'ArticleController@edit')->name('article.save');
    Route::post('/article/edit.do', 'ArticleController@doEdit')->name('article.save');
    Route::post('/article/status.do', 'ArticleController@doStatus')->name('article.save');
    Route::post('/article/remove.do', 'ArticleController@doRemove')->name('article.remove');

    // 分类
    Route::get('/article/category', 'ArticleCategoryController@index')->name('article/category.index');
    Route::get('/article/category/add', 'ArticleCategoryController@add')->name('article/category.save');
    Route::post('/article/category/add.do', 'ArticleCategoryController@doAdd')->name('article/category.save');
    Route::get('/article/category/edit', 'ArticleCategoryController@edit')->name('article/category.save');
    Route::post('/article/category/edit.do', 'ArticleCategoryController@doEdit')->name('article/category.save');
    Route::post('/article/category/status.do', 'ArticleCategoryController@doStatus')->name('article/category.save');
    Route::post('/article/category/remove.do', 'ArticleCategoryController@doRemove')->name('article/category.remove');

    // 横幅
    Route::get('/article/banner', 'ArticleBannerController@index')->name('article/banner.index');
    Route::get('/article/banner/add', 'ArticleBannerController@add')->name('article/banner.save');
    Route::post('/article/banner/add.do', 'ArticleBannerController@doAdd')->name('article/banner.save');
    Route::get('/article/banner/edit', 'ArticleBannerController@edit')->name('article/banner.save');
    Route::post('/article/banner/edit.do', 'ArticleBannerController@doEdit')->name('article/banner.save');
    Route::post('/article/banner/status.do', 'ArticleBannerController@doStatus')->name('article/banner.save');
    Route::post('/article/banner/remove.do', 'ArticleBannerController@doRemove')->name('article/banner.remove');
});

/************************************************************
 *                          其他
 ************************************************************/
Route::middleware(['sign', 'auth.admin', 'permission'])->group(function () {

    Route::get('/index/market', 'IndexController@market')->name('index.index');
    Route::get('/index/order', 'IndexController@order')->name('index.index');
    Route::get('/index/goods', 'IndexController@goods')->name('index.index');
    Route::get('/index/distribution', 'IndexController@distribution')->name('index.index');
    Route::get('/index/cash', 'IndexController@cash')->name('index.index');
});

/************************************************************
 *                          检查 ( 签名、登录 )
 ************************************************************/
Route::middleware(['sign', 'auth.admin'])->group(function () {

    // 个人信息
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile/info', 'ProfileController@info');
    Route::post('/profile/password', 'ProfileController@password');

    // Dialog组件调用
    Route::get('/dialog/user', 'DialogController@user');
    Route::get('/dialog/coupon', 'DialogController@coupon');
    Route::get('/dialog/goods', 'DialogController@goods');
});

/************************************************************
 *                          检查 ( 登录 )
 ************************************************************/
Route::middleware(['auth.admin'])->group(function () {

    // 上传
    Route::post('/upload/{action}/{width?}/{height?}', 'UploadController@index');

});

/************************************************************
 *                          检查 ( 签名 )
 ************************************************************/
Route::middleware(['sign'])->group(function () {

    Route::post('/auth', 'AuthController@index');
    Route::post('/auth/logout', 'AuthController@logout');
    Route::get('/system', 'SystemController@index');
});
