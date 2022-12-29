<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\DebtFinancingController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\InvestmentFundsController;
use App\Http\Controllers\IposController;
use App\Http\Controllers\PodcastsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatementsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaitingDatesController;
use App\Models\Companies;
use App\Models\DealsComplaints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::get('user-info/{id}', [UserController::class, 'getUserInfo']);
Route::post('user/follow', [UserController::class, 'followUser'])->middleware('user.token');
Route::post('user/unfollow', [UserController::class, 'unFollowUser'])->middleware('user.token');
Route::post('user/edit-profile', [UserController::class, 'editProfile'])->middleware('user.token');
Route::post('user/edit-profile/password', [UserController::class, 'editProfilePassword'])->middleware('user.token');
Route::post('user/change-image', [UserController::class, 'changeImage'])->middleware('user.token');
Route::post('user/resend-code', [UserController::class, 'resendCode'])->middleware('user.token');
Route::post('user/verify-phone', [UserController::class, 'verifyPhone'])->middleware('user.token');

Route::post('/verify-email/{token}', [UserController::class, 'verifyEmail']);

Route::get('ads', [AdsController::class, 'getAds']);

Route::get('articles-thumbs', [ArticlesController::class, 'thumbs']);
Route::get('articles', [ArticlesController::class, 'getArticles']);
Route::get('article/{id}', [ArticlesController::class, 'getArticle']);
Route::post('article/add-comment', [ArticlesController::class, 'addComment'])->middleware('user.token');

Route::get('most-articles', [ArticlesController::class, 'getMostArticles']);

Route::get('waiting-dates', [WaitingDatesController::class, 'getWaitingDates']);
Route::get('waiting-dates/{date}', [WaitingDatesController::class, 'getWaitingDatesByDate']);

Route::get('investment-funds', [InvestmentFundsController::class, 'getInvestmentFunds']);
Route::get('investment-funds/limited', [InvestmentFundsController::class, 'getLimitedInvestmentFunds']);
Route::get('investment-fund/{id}', [InvestmentFundsController::class, 'getInvestmentFund']);

Route::get('projects/limited', [ProjectsController::class, 'getLimitedProjects']);
Route::get('projects', [ProjectsController::class, 'getAllProjects']);
Route::get('project/{id}', [ProjectsController::class, 'getProject']);

Route::get('appointments', [AppointmentsController::class, 'getAppointments']);

Route::get('ipos/limited', [IposController::class, 'getLimitedIpos']);
Route::get('ipos', [IposController::class, 'getIpos']);
Route::get('ipos/{id}', [IposController::class, 'getIposByID']);

Route::get('companies/limited', [CompaniesController::class, 'getLimitedCompanies']);
Route::get('companies', [CompaniesController::class, 'getCompanies']);
Route::get('company/{id}', [CompaniesController::class, 'getCompany']);

Route::get('statements/{year}', [StatementsController::class, 'getStatements']);

Route::get('debt-financing/platforms', [DebtFinancingController::class, 'getPlatforms']);
Route::get('debt-financing/companies', [DebtFinancingController::class, 'getCompanies']);
Route::get('debt-financing/statistics', [DebtFinancingController::class, 'getStatistics']);

Route::get('podcasts', [PodcastsController::class, 'getPodcasts']);
Route::get('podcasts/limited', [PodcastsController::class, 'getLimitedPodcasts']);
Route::get('podcast/{id}', [PodcastsController::class, 'getPodcast']);

Route::get('deal', [DealsController::class, 'summary']);

Route::get('search/{keyword}', [SearchController::class, 'search']);
Route::get('search-ads/{keyword}', [SearchController::class, 'searchAds']);

Route::post('exchange-ads', [ExchangeController::class, 'addAd'])->middleware('user.token');
Route::post('exchange-ads/user', [ExchangeController::class, 'getAdsByUser'])->middleware('user.token');
Route::get('exchange-ads', [ExchangeController::class, 'getAds']);
Route::get('exchange-ads/limited', [ExchangeController::class, 'getLimitedAds']);
Route::get('exchange-ads/{id}', [ExchangeController::class, 'getAd']);
Route::post('exchange-ads/add-offer', [ExchangeController::class, 'addOffer'])->middleware('user.token');
Route::post('exchange-ads/cancel-offer', [ExchangeController::class, 'cancelOffer'])->middleware('user.token');

Route::post('/chats', [ChatController::class, 'getChats'])->middleware('user.token');
Route::post('/chat/new', [ChatController::class, 'newChat'])->middleware('user.token');
Route::post('/chat', [ChatController::class, 'getChat'])->middleware('user.token');
Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->middleware('user.token');
Route::post('/chat/approve-deal/{id}', [ChatController::class, 'approveDeal'])->middleware('user.token');

Route::post('get-notifications', [UserController::class, 'getNotifications'])->middleware('user.token');
Route::post('read-notification/{id}', [UserController::class, 'readNotification'])->middleware('user.token');

Route::post('/deal/get-deal', [DealsController::class, 'getDeal'])->middleware('user.token');
Route::post('/deal/complete-deal', [DealsController::class, 'completeDeal'])->middleware('user.token');
Route::post('/deal/revert-deal', [DealsController::class, 'revertDeal'])->middleware('user.token');
Route::post('/deal/completed-deal', [DealsController::class, 'completedDeal'])->middleware('user.token');
Route::post('/deal/cancel-deal', [DealsController::class, 'cancelDeal'])->middleware('user.token');
Route::post('/deal/record-complaint', [DealsController::class, 'recordComplaint'])->middleware('user.token');

Route::group(['prefix' => 'admin'], function () {

    Route::post('auth/login', [AdminsController::class, 'login']);

    Route::get('articles', [ArticlesController::class, 'getAllArticles']);
    Route::post('articles', [ArticlesController::class, 'createArticle']);
    Route::put('edit-article/{id}', [ArticlesController::class, 'updateArticle']);
    Route::delete('articles/{id}', [ArticlesController::class, 'deleteArticle']);
    Route::put('articles/{type}/{id}', [ArticlesController::class, 'draftArticle']);

    Route::post('ads', [AdsController::class, 'addAds']);

    Route::get('companies', [CompaniesController::class, 'getCompanies']);
    Route::post('companies', [CompaniesController::class, 'createCompany']);
    Route::put('edit-company/{id}', [CompaniesController::class, 'updateCompany']);
    Route::delete('companies/{id}', [CompaniesController::class, 'deleteCompany']);

    Route::get('statements', [StatementsController::class, 'getAllStatements']);
    Route::post('statements', [StatementsController::class, 'createStatement']);
    Route::delete('statements/{id}', [StatementsController::class, 'deleteStatement']);

    Route::get('ipos', [IposController::class, 'getIpos']);
    Route::post('ipos', [IposController::class, 'createIpos']);
    Route::put('edit-ipos/{id}', [IposController::class, 'updateIpos']);
    Route::delete('ipos/{id}', [IposController::class, 'deleteIpos']);

    Route::get('investment-funds', [InvestmentFundsController::class, 'getInvestmentFunds']);
    Route::post('investment-funds', [InvestmentFundsController::class, 'createInvestmentFunds']);
    Route::put('edit-investment-funds/{id}', [InvestmentFundsController::class, 'editInvestmentFunds']);
    Route::delete('investment-funds/{id}', [InvestmentFundsController::class, 'deleteInvestmentFunds']);

    Route::get('appointments', [AppointmentsController::class, 'getAppointments']);
    Route::get('appointment/{id}', [AppointmentsController::class, 'getAppointment']);
    Route::post('appointments', [AppointmentsController::class, 'createAppointment']);
    Route::put('appointments/{id}', [AppointmentsController::class, 'editAppointment']);
    Route::delete('appointments/{id}', [AppointmentsController::class, 'deleteAppointment']);

    Route::get('debt-financing/platforms/{id}', [DebtFinancingController::class, 'getPlatform']);
    Route::post('debt-financing/platforms', [DebtFinancingController::class, 'createPlatforms']);
    Route::put('debt-financing/platforms/{id}', [DebtFinancingController::class, 'editPlatforms']);
    Route::delete('debt-financing/platforms/{id}', [DebtFinancingController::class, 'deletePlatforms']);

    Route::get('debt-financing/companies/{id}', [DebtFinancingController::class, 'getCompany']);
    Route::post('debt-financing/companies', [DebtFinancingController::class, 'createCompanies']);
    Route::put('debt-financing/companies/{id}', [DebtFinancingController::class, 'editCompany']);
    Route::delete('debt-financing/companies/{id}', [DebtFinancingController::class, 'deleteCompanies']);

    Route::post('debt-financing/statistics', [DebtFinancingController::class, 'createStatistics']);
    Route::delete('debt-financing/statistics/{id}', [DebtFinancingController::class, 'deleteStatistics']);

    Route::get('podcasts', [PodcastsController::class, 'getAllPodcasts']);
    Route::post('podcasts', [PodcastsController::class, 'createPodcasts']);
    Route::put('podcasts/{id}', [PodcastsController::class, 'editPodcasts']);
    Route::delete('podcasts/{id}', [PodcastsController::class, 'deletePodcast']);

    Route::get('categories', [CategoriesController::class, 'getCategories']);
    Route::post('categories', [CategoriesController::class, 'createCategories']);
    Route::delete('categories/{id}', [CategoriesController::class, 'deleteCategories']);

    Route::get('projects', [ProjectsController::class, 'getProjects']);
    Route::post('projects', [ProjectsController::class, 'createProjects']);
    Route::put('projects/{id}', [ProjectsController::class, 'editProjects']);
    Route::delete('projects/{id}', [ProjectsController::class, 'deleteProjects']);

    Route::put('/edit-exchange-ad/{id}', [ExchangeController::class, 'editExchangeAd']);
    Route::delete('/exchange-ad/{id}', [ExchangeController::class, 'deleteExchangeAd']);

    Route::get('/deals-complaint', function () {
        return DealsComplaints::with('deal')->get();
    });
    Route::get('/deal-complaint/{id}', function ($id) {
        return DealsComplaints::where('id', $id)->with('deal')->fist();
    });

    Route::get('users', [UserController::class, 'getAllUsers']);
    Route::post('users/{id}/verify', [UserController::class, 'verifyUser']);
    Route::delete('users/{id}', [UserController::class, 'deleteUser']);

    Route::get('admins', [AdminsController::class, 'getAdmins']);
    Route::post('admins', [AdminsController::class, 'createAdmin']);
    Route::delete('admins/{id}', [AdminsController::class, 'deleteAdmin']);

    Route::post('update-profile', [AdminsController::class, 'updateProfile']);
    Route::post('update-password', [AdminsController::class, 'updatePassword']);
});
