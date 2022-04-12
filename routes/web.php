<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Route::get('/', function () {
//     return view('web/home');
// });


// // Authentication Routes...
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// // Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
// Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// // Confirm Password (added in v6.2)
// Route::get('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
// Route::post('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);

// Email Verification Routes...
Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
// Route::get('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');
Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::group([],function() {
    // // Registration Routes...
    Route::get('login', [App\Http\Controllers\WebMasterController::class, 'login'])->name('login');
    Route::get('logout', [App\Http\Controllers\User\MasterController::class, 'logout'])->name('logout');

    Route::post('loginAction', [App\Http\Controllers\WebMasterController::class, 'loginAction'])->name('loginAction');
    Route::get('register', [App\Http\Controllers\WebMasterController::class, 'register'])->name('register');
    Route::post('registerAction', [App\Http\Controllers\WebMasterController::class, 'registerAction'])->name('registerAction');
    Route::get('userVerification/{token}', [App\Http\Controllers\WebMasterController::class, 'userVerification'])->name('userVerification');

    // Auth::routes();
    // Home Page
    Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('/booksByCategory/{category_id}', [App\Http\Controllers\HomeController::class, 'booksByCategory'])->name('booksByCategory');
    Route::get('/bookSingle/{book_id}', [App\Http\Controllers\HomeController::class, 'bookSingle'])->name('bookSingle');

    Route::get('/login/facebook', [App\Http\Controllers\Auth\LoginController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleFacebookCallback'])->name('blog');
    Route::get('bookDetails', [App\Http\Controllers\Auth\HomeController::class, 'bookDetails'])->name('bookDetails');
    
    Route::group(['prefix'=>'cart', 'as'=>'cart.'], function (){
        Route::post('/cartAdd', [App\Http\Controllers\AddToCartController::class, 'cartAdd'])->name('cartAdd');
        Route::post('/nav_cart', [App\Http\Controllers\AddToCartController::class, 'nav_cart'])->name('nav_cart');
        Route::post('/toolbar', [App\Http\Controllers\AddToCartController::class, 'toolbar'])->name('toolbar');
        Route::post('/removeFromCart', [App\Http\Controllers\AddToCartController::class, 'removeFromCart'])->name('removeFromCart');
        Route::post('/updateViewCartPage', [App\Http\Controllers\AddToCartController::class, 'updateViewCartPage'])->name('updateViewCartPage');
    });
    Route::post('/checkoutAction', [App\Http\Controllers\CheckoutController::class, 'checkoutAction'])->name('checkoutAction');
    
    Route::group(['middleware' => 'userAuth'], function (){
        Route::get('/viewCart', [App\Http\Controllers\HomeController::class, 'viewCart'])->name('viewCart');
        Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
        Route::post('/addRating/{product_id}', [App\Http\Controllers\HomeController::class, 'addRating'])->name('addRating');
    });
});

Route::group(['prefix' => 'user', 'as'=>'user.'], function (){

    //Login & Logout
    Route::get('/', ['as'=>'login', function (){ return redirect()->route('user.login');}]);
    Route::get('login', [App\Http\Controllers\User\MasterController::class, 'getLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\User\MasterController::class, 'postLogin']);
    Route::post('logout', [App\Http\Controllers\User\MasterController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'userAuth'], function (){
        Route::get('home', [App\Http\Controllers\User\MasterController::class, 'home'])->name('home');
        Route::get('profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
        Route::put('profileUpdate/{id}', [App\Http\Controllers\User\ProfileController::class, 'updateProfile'])->name('profileUpdate');
        Route::put('profilePassUpdate/{id}', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('profilePassUpdate');

        //BOOK ROUTE
        Route::resource('addAuthor', App\Http\Controllers\User\AuthorController::class);
        Route::resource('addBook', App\Http\Controllers\User\AddBookController::class);
        Route::group(['prefix' => 'bookRequest', 'as'=>'bookRequest.'], function (){
            Route::get('/', [App\Http\Controllers\User\BookRequestController::class, 'index'])->name('index');
            Route::get('requestControl/{id}', [App\Http\Controllers\User\BookRequestController::class, 'requestControl'])->name('requestControl');
            Route::post('requestControlAction/{id}', [App\Http\Controllers\User\BookRequestController::class, 'requestControlAction'])->name('requestControlAction');
            Route::get('returnBookByOwner/{book_id}', [App\Http\Controllers\User\BookRequestController::class, 'returnBookByOwner'])->name('returnBookByOwner');
            Route::post('returnBookByOwnerAction/{book_id}', [App\Http\Controllers\User\BookRequestController::class, 'returnBookByOwnerAction'])->name('returnBookByOwnerAction');
        });
        Route::group(['prefix' => 'myRequest', 'as'=>'myRequest.'], function (){
            Route::get('/', [App\Http\Controllers\User\MyRequestController::class, 'index'])->name('index');
            Route::get('ownerDetails/{owner_id}', [App\Http\Controllers\User\MyRequestController::class, 'ownerDetails'])->name('ownerDetails');
            Route::get('returnBook/{book_id}', [App\Http\Controllers\User\MyRequestController::class, 'returnBook'])->name('returnBook');
            Route::post('returnBookAction/{book_id}', [App\Http\Controllers\User\MyRequestController::class, 'returnBookAction'])->name('returnBookAction');
        });
    });
});
Route::group(['prefix' => 'provider', 'as'=>'provider.'], function (){

    //Login & Logout
    Route::get('/', ['as'=>'login', function (){ return redirect()->route('provider.login');}]);
    Route::get('login', [App\Http\Controllers\Provider\MasterController::class, 'getLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\Provider\MasterController::class, 'postLogin']);
    Route::post('logout', [App\Http\Controllers\Provider\MasterController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'providerAuth'], function (){
        Route::get('home', [App\Http\Controllers\Provider\MasterController::class, 'home'])->name('home');
        Route::get('profile', [App\Http\Controllers\Provider\ProfileController::class, 'index'])->name('profile');
        Route::put('profileUpdate/{id}', [App\Http\Controllers\Provider\ProfileController::class, 'updateProfile'])->name('profileUpdate');
        Route::put('profilePassUpdate/{id}', [App\Http\Controllers\Provider\ProfileController::class, 'updatePassword'])->name('profilePassUpdate');

        Route::resource('author', App\Http\Controllers\Provider\AuthorController::class);
        Route::get('author/authorActiveStatus/{user_id}', [App\Http\Controllers\Provider\AuthorController::class, 'authorActiveStatus'])->name('author.authorActiveStatus');
        Route::post('author/authorActiveStatusAction/{user_id}', [App\Http\Controllers\Provider\AuthorController::class, 'authorActiveStatusAction'])->name('author.authorActiveStatusAction');
        Route::resource('bookCategory', App\Http\Controllers\Provider\BookCategoryController::class);
        Route::resource('language', App\Http\Controllers\Provider\LanguageController::class);
        Route::resource('allUsers', App\Http\Controllers\Provider\AllUsersController::class);
        Route::get('allUsers/bookListByUser/{user_id}', [App\Http\Controllers\Provider\AllUsersController::class, 'bookListByUser'])->name('bookListByUser');
        Route::get('allUsers/userActiveStatus/{user_id}', [App\Http\Controllers\Provider\AllUsersController::class, 'userActiveStatus'])->name('userActiveStatus');
        Route::post('allUsers/userActiveStatusAction/{user_id}', [App\Http\Controllers\Provider\AllUsersController::class, 'userActiveStatusAction'])->name('userActiveStatusAction');

        Route::get('allBooks', [App\Http\Controllers\Provider\AllBooksController::class, 'allBooks'])->name('allBooks');
        Route::get('bookApproval/{book_id}', [App\Http\Controllers\Provider\AllBooksController::class, 'bookApproval'])->name('bookApproval');
        Route::post('bookApprovalAction/{book_id}', [App\Http\Controllers\Provider\AllBooksController::class, 'bookApprovalAction'])->name('bookApprovalAction');





        Route::resource('studentReview', App\Http\Controllers\Provider\StudentReviewController::class);
        Route::resource('recentVideo', App\Http\Controllers\Provider\RecentVideoController::class);
        Route::resource('photoGallery', App\Http\Controllers\Provider\PhotoGalleryController::class);
        
        Route::get('workFlow', [App\Http\Controllers\Provider\WorkFlowController::class, 'workFlow'])->name('workFlow');
        Route::post('saveWorkFlow', [App\Http\Controllers\Provider\WorkFlowController::class, 'saveWorkFlow'])->name('saveWorkFlow');

        Route::resource('blog', App\Http\Controllers\Provider\BlogController::class);
        Route::get('blog/comment-list/{blogId}', [App\Http\Controllers\Provider\BlogCommentController::class, 'commentList'])->name('blog.commentList');
        Route::get('blog/commentPublish/{id}', [App\Http\Controllers\Provider\BlogCommentController::class, 'commentPublish'])->name('blog.commentPublish');
        Route::post('blog/commentPublish/{id}', [App\Http\Controllers\Provider\BlogCommentController::class, 'commentPublishAction'])->name('blog.commentPublishAction');

        //TEACHER
        Route::resource('teacher', App\Http\Controllers\Provider\CourseTeacherController::class);
        // COURSE
        Route::resource('course', App\Http\Controllers\Provider\CourseController::class);
        // ASSIGN TEACHER
        Route::get('courseAssignTeacher/{id}', [App\Http\Controllers\Provider\CourseController::class, 'assignTeacher'])->name('courseAssignTeacher');
        Route::post('courseAssignTeacher/{id}', [App\Http\Controllers\Provider\CourseController::class, 'assignTeacherAction'])->name('courseAssignTeacher');
        
        // ASSIGN PACKAGE
        Route::resource('assignPackage', App\Http\Controllers\Provider\AssignCoursePackageController::class);
        Route::get('packagePublish/{id}', [App\Http\Controllers\Provider\AssignCoursePackageController::class, 'packagePublish'])->name('packagePublish');
        Route::post('packagePublish/{id}', [App\Http\Controllers\Provider\AssignCoursePackageController::class, 'packagePublishAction'])->name('packagePublish');
        // ASSIGN PACKAGE FEATURES
        Route::get('assignPackageFeatureList/{package_id}', [App\Http\Controllers\Provider\AssignCoursePackageController::class, 'assignPackageFeatureList'])->name('assignPackageFeatureList');
        Route::get('assignPackageFeature/{package_id}', [App\Http\Controllers\Provider\AssignCoursePackageController::class, 'packageFeature'])->name('assignPackageFeature');
        Route::post('assignPackageFeature/{package_id}', [App\Http\Controllers\Provider\AssignCoursePackageController::class, 'packageFeatureAction'])->name('assignPackageFeature');
        Route::get('assignPackageFeatureDelete/{feature_id}', [App\Http\Controllers\Provider\AssignCoursePackageController::class, 'packageFeatureDelete'])->name('assignPackageFeatureDelete');
        
        // STUDENT LOGIN SUPPORT
        Route::get('studentList', [App\Http\Controllers\Provider\StudentSupportController::class, 'index'])->name('studentList');
        Route::get('traineeUserLogin', [App\Http\Controllers\Provider\StudentSupportController::class, 'traineeUserLogin'])->name('traineeUserLogin');

        Route::resource('scheduledList', App\Http\Controllers\Provider\AssignCourseScheduleController::class);
        Route::get('scheduledListCourses', [App\Http\Controllers\Provider\AssignCourseScheduleController::class, 'scheduledCourses'])->name('scheduledListCourses');
    });
});
