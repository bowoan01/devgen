<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectImageController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PortfolioController;
use App\Http\Controllers\Site\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('site.home');
Route::get('/about', [AboutController::class, 'index'])->name('site.about');
Route::get('/services', [ServiceController::class, 'index'])->name('site.services');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('site.services.show');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('site.portfolio');
Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('site.portfolio.show');
Route::get('/contact', [ContactController::class, 'index'])->name('site.contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('site.contact.submit');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
    Route::post('/admin/services', [AdminServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}', [AdminServiceController::class, 'show'])->name('admin.services.show');
    Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');

    Route::get('/admin/projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::post('/admin/projects', [AdminProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/admin/projects/{project}', [AdminProjectController::class, 'show'])->name('admin.projects.show');
    Route::put('/admin/projects/{project}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');
    Route::post('/admin/projects/{project}/images/reorder', [ProjectImageController::class, 'reorder'])->name('admin.projects.images.reorder');
    Route::delete('/admin/project-images/{image}', [ProjectImageController::class, 'destroy'])->name('admin.projects.images.destroy');

    Route::get('/admin/team', [AdminTeamController::class, 'index'])->name('admin.teams.index');
    Route::post('/admin/team', [AdminTeamController::class, 'store'])->name('admin.teams.store');
    Route::get('/admin/team/{team}', [AdminTeamController::class, 'show'])->name('admin.teams.show');
    Route::put('/admin/team/{team}', [AdminTeamController::class, 'update'])->name('admin.teams.update');
    Route::delete('/admin/team/{team}', [AdminTeamController::class, 'destroy'])->name('admin.teams.destroy');

    Route::get('/admin/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/export', [AdminContactController::class, 'export'])->name('admin.contacts.export');
    Route::get('/admin/contacts/{contact}', [AdminContactController::class, 'show'])->name('admin.contacts.show');
    Route::patch('/admin/contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('admin.contacts.update-status');
    Route::delete('/admin/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
});
