<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::group('admin',function (){

    //注册页面与注册逻辑
    Route::any('user/register',"@admin/user/register");
    //登录页面与登录逻辑
    Route::any('user/login',"@admin/user/login");
    //修改密码与登录逻辑
    Route::any('user/changepassword',"@admin/user/changepassword");
    //用户管理
    Route::any('user/usermanage',"@admin/user/userManagement");
    //图像上传
    Route::any('user/userupload',"@admin/user/userUploadManagement");

    //后台首页
    Route::get('display/index',"@admin/display/index");


    //公告列表
    Route::get('notice/list',"@admin/notice/index");
    //公告添加页
    Route::get('notice/add',"@admin/notice/addNotice");
    //公告发布
    Route::post('notice/add',"@admin/notice/addNotice");
    //禁用公告
    Route::post('notice/stopNotice',"@admin/notice/stopNotice");
    //启用公告
    Route::post('notice/startNotice',"@admin/notice/startNotice");
    //删除公告
    Route::post('notice/delete',"@admin/notice/delete");


    //业主信息页
    Route::get('host/index',"@admin/host/index");
    //添加业主信息(get访问，Post提交)
    Route::any('host/message',"@admin/host/addHostMessage");
    //编辑业主信息
    Route::any('host/editmessage',"@admin/host/editHostMessage");
    //删除业主信息
    Route::post('host/deletemessage',"@admin/host/deleteHostMessage");


    //公共设施登记页,登记公共设施
    Route::any('machine/add',"@admin/machine/addPublicMachine");
    //公共设施管理页
    Route::get('machine/show',"@admin/machine/showPublicMachine");
    //修改设施
    Route::any('machine/editMachine',"@admin/machine/editPublicMachine");
    //删除设备
    Route::post('machine/deleteMachine',"@admin/machine/deletePublicMachine");
    //管理设施的状态
    Route::post('machine/manageStatus',"@admin/machine/managePublicStatus");
    //显示已损坏或升级设备
    Route::get('machine/showRepair',"@admin/machine/showRepairMachine");
    //添加设备状态信息
    Route::any('machine/addRepairMsg',"@admin/machine/addRepairMachine");
    //编辑维修设备信息
    Route::any('machine/editRepairMsg',"@admin/machine/editRepairMachine");


    //经费管理
    Route::any('funds/showRevenue',"@admin/funds/showRevenueFunds");
    //收费登记
    Route::any('funds/addRevenue',"@admin/funds/addRevenueFunds");
    //编辑收费列表
    Route::any('funds/editFunds',"@admin/funds/editRevenueFunds");
    //删除收费记录
    Route::any('funds/deleteFunds',"@admin/funds/deleteRevenueFunds");
    //支出列表
    Route::any('funds/showExpenditure',"@admin/funds/showExpenditureFunds");
    //支出登记
    Route::any('funds/addExpenditure',"@admin/funds/addExpenditureFunds");
    //支出编辑
    Route::any('funds/editExpenditure',"@admin/funds/editExpenditureFunds");
    //水，电，气列表
    Route::any('funds/showMeter',"@admin/funds/showMeterFunds");
    //水电气登记
    Route::any('funds/addMeter',"@admin/funds/addMeterFunds");
    //水电气修改
    Route::any('funds/editMeter',"@admin/funds/editMeterFunds");
    //收入统计
    Route::any('funds/showStatistics',"@admin/funds/showRevenueStatistics");
    //支出统计
    Route::any('funds/showOut',"@admin/funds/showSpecificCount");
    //支出分类统计
    Route::any('funds/showBrand',"@admin/funds/showBrandFunds");



    //访客和车辆列表
    Route::any('visitor/showvisitor',"@admin/visitor/showEnterVisitor");
    //访客登记
    Route::any('visitor/addvisitor',"@admin/visitor/addEnterVisitor");
    //进入车辆信息列表
    Route::any('visitor/showCar',"@admin/visitor/showEnterCar");
    //增加车辆信息
    Route::any('visitor/addCar',"@admin/visitor/addEnterCar");
    //访问统计
    Route::any('visitor/visitorCount',"@admin/visitor/countEnterVisitor");


});





