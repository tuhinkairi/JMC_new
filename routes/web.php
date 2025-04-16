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
Route::redirect('/', 'login');

Route::get('logout/{id}', 'Auth\LoginController@logout');

// Auth Routes
Auth::routes();
//Auth::routes(['register' => false]);


// Auth Common Routes
Route::group(['middleware' => 'auth', 'XSS'], function()
{
    // Dashboard Route
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard.index');
    Route::post('/switch-account', 'Admin\DashboardController@switch_account')->name('switch.account');
    Route::get('/change_account/{id}', 'Admin\DashboardController@change_account');
});


// Admin Routes
Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['auth', 'isAdmin', 'XSS']], function()
{
    // Article Routes
    Route::resource('article-category', 'Admin\ArticleCategoryController');
    Route::get('article/approve', 'Admin\ArticleController@approve')->name('article.approve');
    Route::get('article/pending', 'Admin\ArticleController@pending')->name('article.pending');
    Route::get('article/reject', 'Admin\ArticleController@reject')->name('article.reject');
    Route::get('article/show/{id}', 'Admin\ArticleController@show')->name('article.show');
    Route::post('article', 'Admin\ArticleController@store')->name('article.store');
    Route::put('article/{id}', 'Admin\ArticleController@update')->name('article.update');
    Route::delete('article/{id}', 'Admin\ArticleController@destroy')->name('article.destroy');
    Route::get('article/show_review_evalution/{param}', 'Admin\SubmissionController@show_review_question');
    //Submission
    Route::get('submission', 'Admin\SubmissionController@index')->name('new.submission');
    Route::get('submission/create', 'Admin\SubmissionController@create')->name('create.new.submission');
    Route::get('submission/show/{param}', 'Admin\SubmissionController@show')->name('submission.show');
    Route::post('submission/add', 'Admin\SubmissionController@store')->name('submission.article.store');
    Route::put('submission/{id}', 'Admin\SubmissionController@update')->name('submission.update');
    Route::put('submission/task/{id}', 'Admin\SubmissionController@task')->name('submission.task');
    Route::put('submission/review/{id}', 'Admin\SubmissionController@review')->name('submission.review');
    Route::get('submission/review-question/{param}', 'Admin\SubmissionController@review_question');
    
    // Route::delete('submission/file/{id}', 'Admin\SubmissionController@file_destroy')->name('file.destroy');
//for file tab
    Route::post('submission/plagiarism_report/{param}', 'Admin\SubmissionController@plagiarism_report_file_upload')->name('submission.file.plagiarism_report');
    Route::post('submission/certificate_details/{param}', 'Admin\SubmissionController@certificate_details_file_upload')->name('submission.file.certificate_details');
    Route::post('submission/published_article_details/{param}', 'Admin\SubmissionController@published_article_details_file_upload')->name('submission.file.published_article');
    Route::post('submission/author_file/{id}', 'Admin\SubmissionController@author_file_upload');
    // Staff Routes
    Route::get('staff', 'Admin\StaffController@index')->name('new.staff');
    Route::post('staff/store', 'Admin\StaffController@store')->name('staff.store');

    // Issue Routes
    Route::get('issue/{id}', 'Admin\ArticleIssueController@index')->name('issue.index');
    Route::post('issue', 'Admin\ArticleIssueController@store')->name('issue.store');
    Route::put('issue/{id}', 'Admin\ArticleIssueController@update')->name('issue.update');
    Route::delete('issue/{id}', 'Admin\ArticleIssueController@destroy')->name('issue.destroy');

    // Other Routes
    Route::resource('requirement', 'Admin\RequirementController');
    Route::resource('reviewer', 'Admin\ReviewerController');
    Route::resource('author', 'Admin\AuthorController');
    // Route::resource('staff', 'Admin\StaffController');
    Route::resource('payment', 'Admin\PaymentController');
    // Comment Route
    Route::resource('comment', 'Admin\CommentController');

    // Profile Route
    Route::resource('profile', 'Admin\ProfileController');

    // Setting Routes
    Route::get('setting', 'Admin\SettingController@index')->name('setting.index');
    Route::post('siteinfo', 'Admin\SettingController@siteInfo')->name('setting.siteinfo');
    Route::post('contactinfo', 'Admin\SettingController@contactInfo')->name('setting.contactinfo');
    Route::post('socialinfo', 'Admin\SettingController@socialInfo')->name('setting.socialinfo');
    Route::post('changemail', 'Admin\SettingController@changeMail')->name('setting.changemail');
    Route::post('changepass', 'Admin\SettingController@changePass')->name('setting.changepass');
});


// Reviewer Routes
Route::group(['prefix' => 'dashboard/reviewer', 'as'=>'reviewer.', 'middleware' => ['auth', 'isReviewer', 'XSS']], function()
{

    // Article Routes
    Route::get('article/approve', 'Reviewer\ArticleController@approve')->name('article.approve');
    Route::get('article/pending', 'Reviewer\ArticleController@pending')->name('article.pending');
    Route::get('article/reject', 'Reviewer\ArticleController@reject')->name('article.reject');
    Route::post('article', 'Reviewer\ArticleController@store')->name('article.store');
    Route::put('article/{id}', 'Reviewer\ArticleController@update')->name('article.update');
    Route::delete('article/{id}', 'Reviewer\ArticleController@destroy')->name('article.destroy');
    Route::get('article/indivitual_article_show/{id}', 'Reviewer\ArticleController@indivitual_article_show');


    // Issue Routes
    Route::get('issue/{id}', 'Reviewer\ArticleIssueController@index')->name('issue.index');
    Route::post('issue', 'Reviewer\ArticleIssueController@store')->name('issue.store');
    Route::put('issue/{id}', 'Reviewer\ArticleIssueController@update')->name('issue.update');
    Route::delete('issue/{id}', 'Reviewer\ArticleIssueController@destroy')->name('issue.destroy');

    //Task Routes
    Route::get('review', 'Reviewer\ReviewController@index')->name('reivew.view');
    Route::get('review/show/{id}', 'Reviewer\ReviewController@show');
    // Route::put('task/update/{id}', 'Reviewer\TaskController@update');

    // Profile Route
    Route::resource('profile', 'Reviewer\ProfileController');
});


// Author Routes
Route::group(['prefix' => 'dashboard/author', 'as'=>'author.', 'middleware' => ['auth', 'isAuthor', 'XSS']], function()
{
    // Article Routes
    Route::resource('article', 'Author\ArticleController');

    Route::get('article/show-review-evalution/{param}', 'Author\ArticleController@show_review_question');

    // Issue Routes
    Route::resource('issue', 'Author\ArticleIssueController');

    // Profile Route
    Route::resource('profile', 'Author\ProfileController');

    Route::get('article/indivitual_article_show/{id}', 'Author\ArticleController@indivitual_article_show');
    Route::get('addarticle', 'Author\ArticleController@addarticle');
    Route::get('copyright_acceptance', 'Author\ArticleController@copyright_acceptance');
    Route::get('downloads', 'Author\ArticleController@downloads');
    Route::get('faq', 'Author\ArticleController@faq')->name('author.faq');
    Route::get('knowledgebase', 'Author\ArticleController@knowledgebase')->name('author.knowledgbase');
    Route::post('article/file/{id}', 'Author\ArticleController@file_upload');
    Route::post('submission/author_file/{id}', 'Author\ArticleController@author_file_upload');

    // Route::post('submission/plagiarism_report/{param}', 'Author\ArticleController@plagiarism_report_file_upload');
    // Route::post('submission/certificate_details/{param}', 'Author\ArticleController@certificate_details_file_upload');
    // Route::post('submission/published_article_details/{param}', 'Author\ArticleController@published_article_details_file_upload');

});


//Staff Routes
Route::group(['prefix' => 'dashboard/staff', 'as'=>'staff.', 'middleware' => ['auth', 'isStaff', 'XSS']], function()
{
    // Tasks Routes
    Route::get('task', 'Staff\StaffController@index')->name('task.index');
    Route::get('task/show/{id}', 'Staff\StaffController@show');
    Route::post('task/update/{id}', 'Staff\StaffController@update')->name('staff.store.task');
    Route::get('show/{id}', 'Staff\StaffController@show');

    // // Issue Routes
    // Route::resource('issue', 'Author\ArticleIssueController');
    Route::post('submission/author_file/{param}', 'Staff\StaffController@author_file_upload');
    Route::post('submission/plagiarism_report/{param}', 'Staff\StaffController@plagiarism_report_file_upload');
    Route::post('submission/certificate_details/{param}', 'Staff\StaffController@certificate_details_file_upload');
    Route::post('submission/published_article_details/{param}', 'Staff\StaffController@published_article_details_file_upload');
    // Profile Route
    Route::resource('profile', 'Staff\ProfileController');
});

//Route For List View Al data from dashboart
Route::get('dashboard/author/article/show/{id}', 'Author\ArticleController@show');

Route::get('dashboard/admin/submission/show/{id}', 'Admin\SubmissionController@show');

//Detail page data Dynamic change
Route::post('dashboard/admin/submission/journal_ajax','Admin\SubmissionController@change_details');

//Kan Ban list data change
Route::post('dashboard/admin/submission/kan-ban-task','Admin\SubmissionController@change_kan_ban_task');

Route::post('dashboard/admin/submission/kan-ban-review','Admin\SubmissionController@change_kan_ban_review');

//file upload tab
Route::post('dashboard/admin/submission/file/{id}', 'Admin\SubmissionController@file_upload');


//copy right form upload tab
Route::post('dashboard/admin/submission/copy_right_file/{id}', 'Admin\SubmissionController@copy_right_file');
Route::get('dashboard/admin/submission/copyright_form/{id}', 'Admin\SubmissionController@copyright_form');
Route::get('dashboard/admin/submission/download_final_submission_format', 'Admin\SubmissionController@download_final_submission_format');
//Change the table depend on journal on admn dashboard
Route::post('dashboard/admin/dashboard_ajax','Admin\DashboardController@change_details');

Route::post('dashboard/admin/dashboard_table','Admin\DashboardController@dashboard_table');


//Change the table depend on journal on admn submission
Route::post('dashboard/admin/submission_ajax','Admin\SubmissionController@submission_ajax');

Route::post('dashboard/admin/table_content_depent_by_id','Admin\DashboardController@table_content_depent_by_id');

Route::post('dashboard/admin/table_content_depent_by_author_name','Admin\DashboardController@table_content_depent_by_author_name');

Route::post('dashboard/admin/table_content_depent_by_article_title','Admin\DashboardController@table_content_depent_by_article_title');

//To Download the copy right agrreement form
// Route::post('dashboard/admin/submission/copyright_form','Admin\SubmissionController@copyright_form');
Route::post('dashboard/admin/submission/acceptance_action','Admin\SubmissionController@acceptance_action');
//To insert acceptance details
Route::post('dashboard/admin/submission/acceptance/{id}', 'Admin\SubmissionController@acceptance');

Route::post('dashboard/admin/submission/final_submission_manuscript/{id}', 'Admin\SubmissionController@final_submission_manuscript');
Route::post('dashboard/admin/submission/final_submission_payment_manuscript/{id}', 'Admin\SubmissionController@final_submission_payment_manuscript');
Route::post('dashboard/admin/submission/final_submission_copyright_form/{id}', 'Admin\SubmissionController@final_submission_copyright_form');

Route::put('final_submission_edit/{id}', 'Admin\SubmissionController@final_submission_update')->name('final_submission.update');
Route::post('dashboard/admin/submission/add-review-question/{id}', 'Admin\SubmissionController@add_review_question');
Route::post('dashboard/admin/submission/review_decision','Admin\SubmissionController@review_decision');
Route::post('dashboard/admin/submission/acceptance_status','Admin\SubmissionController@acceptance_status');


Route::post('dashboard/reviewer/review/add-review-question/{id}', 'Reviewer\ReviewController@review_question');

Route::get('dashboard/admin/submission/acceptance_letter/{id}', 'Admin\SubmissionController@acceptance_letter');
Route::post('dashboard/admin/submission/edit-review-question/{id}', 'Admin\SubmissionController@edit_review_question');

Route::post('dashboard/admin/submission/payment_status','Admin\SubmissionController@payment_status');

Route::get('final_submission_freeze/{id}', 'Admin\SubmissionController@final_submission_freeze')->name('final_submission.freeze');
Route::get('final_submission_unfreeze/{id}', 'Admin\SubmissionController@final_submission_unfreeze')->name('final_submission.unfreeze');
Route::post('dashboard/admin/submission/file/destroy/{id}', 'Admin\SubmissionController@file_destroy');


