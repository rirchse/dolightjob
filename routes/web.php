<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/developer/login', function (){
	return view('auth.admin_login');
});

Route::get('/', function () {
	return view('homes.index');
});
Route::get('/about', function () {
	return view('homes.about');
});
Route::get('/contact', function () {
	return view('homes.contact');
});
Route::get('/signup', function (){
	return view('auth.signup');
});
Route::post('/signup_store', 'Auth\RegisterController@signup_store')->name('signup');
Route::get('/email-verify/{id}/{token}', 'Auth\RegisterController@emailVerify');
Route::post('/user-login', 'Auth\LoginController@login')->name('user.login');
/* ------------------- forgot password ---------------*/
Route::resource('password', 'Auth\ForgotPasswordController');

/*-------------------- cron job routes ---------------*/
Route::get('/back_auto_pause', 'HomeController@backAutoPause');
Route::get('/complete_task', 'HomeController@completeTask');
Route::get('/time_over_task/delete', 'HomeController@deleteTimeOverTask');
//test email submission
Route::get('/send_email_cronjob', 'HomeController@sendTestMail');
Route::get('/cronjob_test', 'HomeController@cronjobtest');

/*--------------------- Auth Routes ------------------*/
Auth::routes();
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return redirect('/');
});
Route::get('/login_to_user/{user}', 'HomeCtrl@loginToUserPanel');
/* my profile information update */
Route::get('/profile_edit', 'HomeCtrl@profile_edit');
Route::put('/profile_update', 'HomeCtrl@profile_update')->name('profile.update');
Route::get('/password_change', 'HomeCtrl@password_change');
Route::put('/password_change/{id}', 'HomeCtrl@password_update')->name('password.change');

Route::get('/home', 'HomeCtrl@findJob')->name('home');
// Route::get('/home', 'HomeCtrl@index')->name('home');

//=================================CASTOM ROUTE===============================
	Route::get('/user/delete/{id}','UserCtrl@destroy')->name('user.delete');
	Route::get('/category/delete/{id}','CategoryCtrl@destroy')->name('category.delete');
	Route::get('/sub_category/delete/{id}','SubCategoryCtrl@destroy')->name('sub_category.delete');
	Route::get('/myjob/delete/{id}','MyjobCtrl@destroy')->name('myjob.delete');
	Route::get('/customer/delete/{id}','CustomerCtrl@destroy')->name('customer.delete');


	Route::get('/payment/{id}/get', 'PaymentCtrl@getPayment')->name('get.payment');
	Route::get('/payment/{id}/index', 'PaymentCtrl@index')->name('index.payment');
	Route::get('/payment/{id}/read', 'PaymentCtrl@show')->name('show.payment');
	Route::get('/payment/{id}/delete','PaymentCtrl@destroy')->name('payment.delete');

//=================================CASTOM ROUTE END ==========================
	
	//user routes
	Route::resource('/user', 'UserCtrl');
	Route::get('/user_search', function(){
		return redirect('/user');
	});
	Route::get('/user_review/{id}', 'UserCtrl@userReview');
	Route::post('/user_search', 'UserCtrl@userSearch')->name('user.search');
	Route::resource('/category', 'CategoryCtrl');

	Route::resource('/sub_category', 'SubCategoryCtrl');
	//ajax call route
	Route::get('/get_sub_cats/{catid}', 'SubCategoryCtrl@subCats');

	Route::resource('/myjob', 'MyjobCtrl');
	Route::post('/myjob_search', 'MyjobCtrl@myjobSearch')->name('myjob.search');
	Route::resource('/mytask', 'MyTaskCtrl');

	Route::resource('/customer', 'CustomerCtrl');
	Route::resource('/sale', 'SaleCtrl');	
	Route::get('/sale/{customer}/myjob', 'SaleCtrl@saleMyjob');
	Route::get('/sale/{id}/print', 'SaleCtrl@print');
	Route::get('/sale/delete/{id}','SaleCtrl@destroy')->name('sale.delete');

	Route::get('/jobs', 'HomeCtrl@findJob');
	Route::post('/jobs', 'HomeCtrl@searchJob')->name('findjob');
	Route::get('/jobs/{id}', 'HomeCtrl@read');
	Route::get('/job_apply/{id}', 'MyTaskCtrl@apply');
	Route::get('/myjob/cancel/{id}', 'MyTaskCtrl@cancel');
	Route::get('/mytask/submit/{id}', 'MyTaskCtrl@submit');
	Route::get('/myjob/{id}/prove', 'MyjobCtrl@myjob_prove');
	Route::get('/myjob/{id}/prove_allow', 'MyjobCtrl@prove_allow');
	Route::get('/myjob/{id}/approve', 'MyjobCtrl@approve');
	Route::put('/myjob/auto_pause/{id}', 'MyjobCtrl@autoPause')->name('myjob.auto_pause');

	//user diposts
	Route::resource('/diposit', 'DipositCtrl');
	Route::get('/diposit/{id}/approve', 'DipositCtrl@approve');
	Route::get('/diposit/{id}/delete', 'DipositCtrl@delete');
	Route::get('/earning_to_diposit', 'DipositCtrl@earningDeposit');

	//task submit
	Route::put('/task/{id}/submit', 'MyTaskCtrl@task_submit')->name('task.submit');
	Route::post('/task/{id}/approve', 'MyTaskCtrl@task_approve')->name('task.approve');
	Route::get('/task/{id}/delete', 'MyTaskCtrl@delete');

	//withdraw
	Route::resource('withdraw', 'WithdrawCtrl');
	Route::get('/withdraw/{id}/approve', 'WithdrawCtrl@approve');
	Route::get('/withdraw/mobile/recharge', 'WithdrawCtrl@rechargeRequest');
	Route::post('/withdraw/mobile/recharge', 'WithdrawCtrl@mobileRecharge')->name('recharge.store');

	Route::get('/withdraw/{id}/delete', 'WithdrawCtrl@delete')->name('withdraw.delete');

	// Route::get('/withdraw/create', function (){
	// 	return '<h1 style="text-align:center;margin-top:20%">This System is under developing.<br><small><a href="/home">back dashboard</a></small></h1>';
	// });
	// Route::get('/withdraw/mobile/recharge', function (){
	// 	return '<h1 style="text-align:center;margin-top:20%">This System is under developing.<br><small><a href="/home">back dashboard</a></small></h1>';
	// });

	Route::get('/view_user_tasks/{id}', 'MyTaskCtrl@userTasks');
	Route::get('/view_user_withdraw/{id}', 'WithdrawCtrl@userWithdraw');
	Route::get('/view_user_jobs/{id}', 'MyjobCtrl@userJobs');
	Route::get('/view_user_deposits/{id}', 'DipositCtrl@userDeposits');

	//make balance by admin
	Route::get('/make_users_balance_by_admin', 'MyTaskCtrl@makeBal');
	Route::get('/make_users_depo_balance_by_admin', 'DipositCtrl@makeDeposit');
	Route::get('/update_user_earning/{id}', 'UserCtrl@updateUserEarning');
	Route::get('/update_user_deposit/{id}', 'UserCtrl@updateUserDeposit');

	//ajax call 
	Route::get('/get_task/{id}', 'MyTaskCtrl@getTask');

	//update job by user
	Route::get('/edit_my_job/{id}', 'MyjobCtrl@editJob');
	Route::put('/update_job/{id}', 'MyjobCtrl@updateJob')->name('update_job.user');
	//job pause by user
	Route::get('/myjob-pause/{id}', 'MyjobCtrl@jobPause');

	//email template test
	Route::get('/check_email_template', function (){
		$name = 'Test Name';
		$url = url('/').md5(0);
		return view('auth.email_verification', compact('name', 'url'));
	});
	//send re-verification email by admin
	Route::get('/send-verify-email/{id}', 'HomeCtrl@sendVerifyEmail');

	//advertiesment 
	Route::resource('/ad', 'AdController');

	//notice
	Route::resource('/notice', 'NoticeCtrl');

	//referel
	Route::get('/{id}/aff', 'HomeController@affiliation');

	//notifications
	Route::get('/message/{id}/read', 'HomeCtrl@messageRead');

	//referrals
	Route::get('/referral', 'HomeCtrl@referral');

	Route::get('/set_cookie', 'HomeController@setCookie');
	Route::get('/get_cookie', 'HomeController@getCookie');

	Route::post('/report', 'HomeCtrl@report')->name('report.store');
	Route::get('/report/{id}/delete', 'HomeCtrl@reportDelete');

	//test route
	Route::get('/get_mac', function (){
		return view('layouts.get_mac');
	});