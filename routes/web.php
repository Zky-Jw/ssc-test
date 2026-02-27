<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentTemplateController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PersonRoleMappingController;
use App\Http\Controllers\RedirectAuthenticatedUsersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceMappingController;
use App\Http\Controllers\ServiceTagController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LecturerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Mews\Captcha\Captcha;
use App\Exports\TicketExport;
use App\Http\Controllers\QuestionController;
use Maatwebsite\Excel\Facades\Excel;


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

//  PHP INFO
Route::get('/php-info', function () {
    return phpinfo();
});

Route::get('/old', function () {
    return Inertia::render('IndexOld');
});

Route::get('/', [MainPageController::class, 'index'])->name('index');
Route::get('/layanan-mandiri', [MainPageController::class, 'selfServicePage']);
Route::get('/detail-ticket/{id?}', [MainPageController::class, 'detailTicketStatus']);
Route::get('/tentang-kami', [MainPageController::class, 'about']);

Route::get('/dummy-page', [MainPageController::class, 'dummyPageTemplate']);
Route::get('/cdn-files/{type}/{ticket}/{filename}', [MainPageController::class, 'cdnFile'])->name('cdn-files');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard/Index');
// })->middleware(['auth', 'verified'])->name('dashboard.index');

Route::group(['middleware' => 'auth'], function () {
    // base dashboard
    // Route::inertia('/dashboard', 'Index')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/generate-surat', [MainPageController::class, 'generateSurat']);
    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, 'index'])->name("redirectAuthenticatedUsers");
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
    Route::put('/profile/update/{person}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/feedback/success', [TicketController::class, 'feedbackSuccess'])->name('feedback.success');
    Route::get('/feedback/{ticketId}', [TicketController::class, 'feedbackPage'])->name('feedback');
    Route::put('/feedback/submit/{ticketId}', [TicketController::class, 'storeFeedback'])->name('submit-feedback');
    Route::get('/buat-tiket/{id}', [MainPageController::class, 'createTicket'])->name('ticket-input');

    // Shared routes
    Route::group(['middleware' => 'roleCheck:102,103,104,105,106'], function () {
        Route::post('/dashboard/ticket/close/{ticket}', [TicketController::class, 'closeTicket'])->name('ticket.close');

        Route::resource('dashboard/document', DocumentController::class);
        Route::get('dashboard/document/generate/{ticket}', [DocumentController::class, 'generate'])->name('document.generate');
        Route::post('dashboard/document/approve/{id}', [DocumentController::class, 'approve'])->name('document.approve');
        Route::get('dashboard/document/creator-check/{id}/{id2}', [DocumentController::class, 'creatorCheck'])->name('document.creator-check');
        Route::get('dashboard/document/approval-check/{id}/{id2}', [DocumentController::class, 'approvalCheck'])->name('document.approval-check');
        Route::get('dashboard/document/print/{id}', [DocumentController::class, 'print'])->name('document.print');

        Route::get('/get-json-template-by-id/{id}', [DocumentTemplateController::class, 'getJsonTemplateById'])->name('get-json-template-by-id');
        Route::get('dashboard/sync', [ApiController::class, 'index'])->name('sync');
    });

    // IT Panel specific routes (roles 102 and 106)
    Route::group(['middleware' => 'roleCheck:102,106'], function () {
        Route::resource('dashboard/unit', UnitController::class);
        Route::resource('dashboard/person', PersonController::class)->except('lecturerIndex');
        Route::resource('dashboard/service', ServiceController::class);
        Route::resource('dashboard/role', RoleController::class);
        Route::resource('dashboard/category', ServiceCategoryController::class);
        Route::resource('dashboard/document-template', DocumentTemplateController::class);

        Route::get('/dashboard/lecturer', [LecturerController::class, 'index'])
            ->name('lecturer.index');
        Route::get('/dashboard/lecturer/{id}/show', [LecturerController::class, 'show'])
            ->name('lecturer.show');

        Route::get('dashboard/privilege', [PersonRoleMappingController::class, 'index'])->name('privilege');
        Route::post('dashboard/privilege/', [PersonRoleMappingController::class, 'store'])->name('privilege.store');
        Route::get('dashboard/privilege/{role}/create', [PersonRoleMappingController::class, 'create'])->name('privilege.create');
        Route::get('dashboard/privilege/{role}', [PersonRoleMappingController::class, 'show'])->name('privilege.show');
        Route::put('dashboard/privilege/{id}', [PersonRoleMappingController::class, 'update'])->name('privilege.update');
        Route::delete('dashboard/privilege/{role}', [PersonRoleMappingController::class, 'destroy'])->name('privilege.destroy');
        Route::get('dashboard/privilege/{role}/edit', [PersonRoleMappingController::class, 'edit'])->name('privilege.edit');

        Route::get('dashboard/modul', [PageController::class, 'index'])->name('modul');
        Route::post('dashboard/modul/', [PageController::class, 'store'])->name('modul.store');
        Route::get('dashboard/modul/create', [PageController::class, 'create'])->name('modul.create');
        Route::get('dashboard/modul/{role}', [PageController::class, 'show'])->name('modul.show');
        Route::put('dashboard/modul/{role}', [PageController::class, 'update'])->name('modul.update');
        Route::delete('dashboard/modul/{role}', [PageController::class, 'destroy'])->name('modul.destroy');
        Route::get('dashboard/modul/{role}/edit', [PageController::class, 'edit'])->name('modul.edit');

        Route::get('dashboard/recipient', [ServiceMappingController::class, 'index'])->name('recipient');
        Route::post('dashboard/recipient/', [ServiceMappingController::class, 'store'])->name('recipient.store');
        Route::get('dashboard/recipient/create', [ServiceMappingController::class, 'create'])->name('recipient.create');
        Route::get('dashboard/recipient/{role}', [ServiceMappingController::class, 'show'])->name('recipient.show');
        Route::put('dashboard/recipient/{role}', [ServiceMappingController::class, 'update'])->name('recipient.update');
        Route::delete('dashboard/recipient/{role}', [ServiceMappingController::class, 'destroy'])->name('recipient.destroy');
        Route::get('dashboard/recipient/{role}/edit', [ServiceMappingController::class, 'edit'])->name('recipient.edit');

        // IT-specific actions
        Route::post('/dashboard/ticket/notify-operator/{ticket}', [TicketController::class, 'notifyOperator'])->name('ticket.notifyOperator');
        Route::post('/dashboard/ticket/notify-creator/{ticket}', [TicketController::class, 'notifyCreator'])->name('ticket.notifyCreator');

        // Create Ticket
        Route::get('dashboard/ticket/create', [TicketController::class, 'create'])->name('ticket.create');

        //Question
        Route::resource('dashboard/question', QuestionController::class);
        Route::get('/export/question', [QuestionController::class, 'export'])->name('question.export');
    });

    // route for user with role 101
    Route::group(['middleware' => 'roleCheck:101'], function () {
        Route::get('/riwayat-pengajuan', [MainPageController::class, 'submissionHistory'])->name('submission-history');
        Route::get('/account', [MainPageController::class, 'profileMenu'])->name('profile-menu');
    });

    // ajax and shared routes for all authenticated users
    Route::get('/get-statistik/unit', [DashboardController::class, 'getStatistikByUnitBulan'])->name('get-statistik-tiket-by-unit');
    Route::get('/get-layanan-terbanyak', [DashboardController::class, 'getLayananTerbanyakByBulan'])->name('get-layanan-terbanyak');
    Route::get('/get-json-person-by-id/{id}', [PersonController::class, 'getJsonPersonById'])->name('get-json-person-by-id');
    Route::get('/students/search', [PersonController::class, 'searchStudent'])->name('students-search');
    Route::get('/get-json-service-by-id/{id}', [ServiceController::class, 'getJsonServiceById'])->name('get-json-service-by-id');
    Route::get('/export/ticket', [TicketController::class, 'export'])->name('ticket.export');

    // ticket progress handling
    Route::post('/dashboard/ticket/store-progress/{ticket}', [TicketController::class, 'storeProgress'])->name('ticket.store-progress');
    Route::resource('dashboard/ticket', TicketController::class)->except(['create']);
});


Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

require __DIR__ . '/auth.php';

// additional info
Route::inertia('/', 'Index')->name('landing-page');
// Route::get('/php-info', function () {return phpinfo();});
// Route::get('/layanan-mandiri', function () {return Inertia::render('SelfServicePage');});
// Route::get('/detail-ticket', function () {return Inertia::render('DetailTicketStatus');});
// Route::get('/tentang-kami', function () {return Inertia::render('About');});

Route::get('/search/services', [ServiceController::class, 'searchByName']);
Route::get('/sync-all-data', [ApiController::class, 'syncAllData']);
Route::get('/sync-people-data', [ApiController::class, 'syncPeopleData']);
Route::get('/sync-user-data', [ApiController::class, 'syncUserData']);
Route::get('/sync-unit-data', [ApiController::class, 'syncUnitData']);
Route::get('/sync-unit-people-data', [ApiController::class, 'syncUnitPeopleData']);
Route::get('/sync-role-people-data', [ApiController::class, 'syncRolePeopleData']);
Route::get('/sync-service-data', [ServiceController::class, 'list']);
Route::get('/sync-service-mapping-data', [ApiController::class, 'syncServiceMappingData']);
Route::get('/service-tags', [ServiceTagController::class, 'index'])->name('service-tags.index');
Route::get('/sync-test', [ApiController::class, 'test']);

Route::get('/captcha', function () {
    return response()->json([
        'captcha' => captcha_img('default')
    ]);
});
