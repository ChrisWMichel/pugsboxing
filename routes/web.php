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

/*Route::get('/', function () {
    return view('welcome');
});*/


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => 'auth'], function (){ /*'prefix' => 'admin', */

    Route::resource('home', 'admin\HomeController', ['only' => ['index', 'update']]);
    Route::resource('header', 'admin\HeaderController', ['except' => ['edit', 'show', 'create']]);

    /*CMS - Categories*/
    Route::resource('categories', 'admin\CategoriesController', ['only' => ['index', 'store']]);
    Route::post('categoryupdate', 'admin\CatController@update');
    Route::get('categorydelete', 'admin\CatController@delete');

    /*CMS - Membership Packages in categories*/
    Route::resource('packages', 'admin\MembershipController', ['only' => ['index', 'store', 'update']]);
    Route::post('packageupdate', 'admin\PackagesController@update');
    Route::get('packagedelete', 'admin\PackagesController@delete');
    Route::get('packagedesc', 'admin\PackagesController@getdesc')->name('packagedesc');

    Route::resource('sale', 'admin\SalesController', ['only' => ['show', 'update']]);

    /*CMS - Class Schedule */
    Route::resource('schedule', 'admin\ScheduleController');
    Route::post('group_name', 'admin\ScheduleController@updateGroupName');
    Route::get('group_delete', 'admin\ScheduleController@delete');
    Route::post('group_create', 'admin\ScheduleController@createGroup');

    /*CMS About Page*/
    Route::resource('about', 'admin\AboutController', ['only' => ['index', 'update']]);

    /*CMS Contact */
    Route::resource('admincontact', 'admin\ContactController', ['only' => ['index', 'update']]);

    /* Members */
    Route::resource('members', 'admin\MembersController', ['only' => ['show', 'store', 'index']]);

    Route::get('new_member', 'admin\MembersController@newMember')->name('new_member');
    Route::get('new_mem_pack/{id}', 'admin\MembersController@newmemberpackage')->name('new_mem_pack');
    Route::get('add_new_mem_pack', 'admin\MembersController@addNewMemberPackage');
    Route::get('add_boxing_pack', 'admin\MembersController@addBoxingPackage');
    Route::get('remove_boxing_pack', 'admin\MembersController@removeBoxingPackage');
    Route::get('add_sparring_pack', 'admin\MembersController@addSparringPackage');

    Route::get('member_edit_profile', 'admin\MembersController@MemberEditProfile');
    Route::post('update_member/{id}', 'admin\MembersController@updateMember');
    Route::get('archive_member', 'admin\MembersController@archiveMember');
    Route::get('reactivate_member', 'admin\MembersController@reactivateMember');
    Route::get('delete_member', 'admin\MembersController@deleteMember');
    Route::post('email_member', 'admin\MembersController@emailMember');

    /* Update Packages */
    Route::get('add_personals', 'admin\UpdatePackageController@addPersonals');
    Route::get('subtract_personals', 'admin\UpdatePackageController@subtractPersonals');
    Route::get('add_sparring', 'admin\UpdatePackageController@addSparring');
    Route::get('subtract_sparring', 'admin\UpdatePackageController@subtractSparring');


    Route::resource('admin', 'admin\MainAdminController', ['only' => ['index', 'destroy']]);
    Route::get('newadmin', 'admin\MainAdminController@newAdmin')->name('newAdmin');
    Route::post('storeadmin', 'admin\MainAdminController@storeAdmin');
    Route::get('open_message_form', 'admin\MainAdminController@openMessageFrm')->name('open_message');
    Route::post('send_message', 'admin\MainAdminController@sendMessage');

    /* Appointments*/
    Route::resource('make_appointment', 'admin\AppointmentsController', ['only' => ['store']]);
    Route::get('autocomplete', 'admin\AppointmentsController@autoComplete')->name('autocomplete');
    Route::get('update_appointments', 'admin\AppointmentsController@updateAppointment');
    Route::get('delete_appointment/{id}', 'admin\AppointmentsController@deleteAppointment');

});

Route::get('/', 'generalPublic\HomesController@index');

Route::get('boxing', 'generalPublic\MainLayoutsController@index')->name('boxing');
Route::post('contact', 'generalPublic\MainLayoutsController@contact')->name('contact');

Route::get('users/verify/{token}', 'UsersController@verify')->name('verify');
Route::post('users', 'UsersController@store')->name('saveUser');
