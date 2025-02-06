<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, ProfileController, AdminController, 
    ParticipantController, TrainingController, CourseController, HomeController
};

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
    Route::get('/', 'profile')->name('index');
    Route::get('/documents', 'showDocuments')->name('documents');
    Route::get('/change-password', 'showChangePassword')->name('change-password');
    Route::put('/update-password', 'updatePassword')->name('update-password');
    Route::get('/preview', 'showPreview')->name('preview');
    Route::put('/update', 'updateProfile')->name('update');
    Route::post('/store', 'storeProfile')->name('store');
    Route::post('/storeOrUpdate', 'storeOrUpdateProfile')->name('storeOrUpdate');
    Route::post('/documents/storeOrUpdate', 'storeOrUpdateDocuments')->name('documents.storeOrUpdate');
    Route::get('/{user}', 'show')->name('show');
});

Route::middleware(['auth', 'role:super_admin|admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/participants', [ParticipantController::class, 'index'])->name('participant_management');
    Route::get('/account-participants', [AdminController::class, 'accountParticipants'])->name('account_participants');
    Route::get('/trainings', [TrainingController::class, 'index'])->name('training_management');
    Route::patch('/participant/{id}/change-role', [AdminController::class, 'changeRole'])->name('change_role');

    Route::delete('/participant/{id}/delete', [ParticipantController::class, 'destroy'])->name('participant.destroy');
    Route::get('/remove-participant/{userId}', [AdminController::class, 'showRemovalForm'])->name('removeParticipantForm');
    Route::post('/remove-participant/{userId}', [AdminController::class, 'removeParticipant'])->name('removeParticipant');
    Route::post('/verify-removal/{id}', [AdminController::class, 'verifyRemoval'])->name('verifyRemoval');

    Route::get('/withdrawals', [AdminController::class, 'withdrawalRequests'])->name('withdrawals');
    Route::post('/withdrawals/{id}/verify', [AdminController::class, 'verifyWithdrawal'])->name('withdrawals.verify');
    Route::post('/withdrawals/{id}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
});

Route::middleware(['auth', 'role:user'])->get('/user/dashboard', fn () => view('user.dashboard'))->name('user.dashboard');

Route::resource('trainings', TrainingController::class);
Route::middleware('auth')->group(function () {
    Route::get('/trainings/{id}/register', [TrainingController::class, 'register'])->name('trainings.register');
    Route::post('/trainings/{id}/process', [TrainingController::class, 'processRegistration'])->name('trainings.process');
    Route::get('/trainings/{id}/participants', [TrainingController::class, 'showParticipants'])->name('trainings.participants');
    Route::post('/profile/training/withdraw/{trainingId}', [ProfileController::class, 'withdraw'])->name('training.withdraw');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('/courses', 'index')->name('courses.index');
    Route::post('/course/register', 'register')->name('course.register');
});

$courseNames = ['barista', 'barbershop', 'digital', 'fotografi', 'grafis', 'jaringan', 'kue', 'membatik', 'menjahit', 'service'];
foreach ($courseNames as $course) {
    Route::view("/courses/$course", "courses.details.$course")->name("courses.$course");
}

Route::middleware('auth')->prefix('participants')->name('participant.')->controller(ParticipantController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
    Route::post('/document/confirm/{id}', 'confirmDocument')->name('document.confirm');
    Route::post('/document/{id}/{type}/revision', 'markAsRevision')->name('document.revision');
    Route::post('/{id}/send-revision', 'sendRevision')->name('sendRevision');
    Route::get('/export', 'export')->name('export');
});
