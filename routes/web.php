<?php

use App\Http\Controllers\Admin\AuthController;
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

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', DashboardController::class)->name('admin.dashboard');

    Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/admin/services/data', [AdminServiceController::class, 'data'])->name('admin.services.data');
    Route::post('/admin/services', [AdminServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/admin/services/{service}', [AdminServiceController::class, 'show'])->name('admin.services.show');
    Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');
    Route::post('/admin/services/reorder', [AdminServiceController::class, 'reorder'])->name('admin.services.reorder');

    Route::get('/admin/projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/admin/projects/data', [AdminProjectController::class, 'data'])->name('admin.projects.data');
    Route::post('/admin/projects', [AdminProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/admin/projects/{project}', [AdminProjectController::class, 'show'])->name('admin.projects.show');
    Route::put('/admin/projects/{project}', [AdminProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}', [AdminProjectController::class, 'destroy'])->name('admin.projects.destroy');
    Route::post('/admin/projects/{project}/toggle-featured', [AdminProjectController::class, 'toggleFeatured'])->name('admin.projects.toggleFeatured');
    Route::post('/admin/projects/{project}/publish', [AdminProjectController::class, 'publish'])->name('admin.projects.publish');
    Route::post('/admin/projects/{project}/unpublish', [AdminProjectController::class, 'unpublish'])->name('admin.projects.unpublish');

    Route::post('/admin/projects/{project}/images', [ProjectImageController::class, 'store'])->name('admin.projects.images.store');
    Route::delete('/admin/projects/{project}/images/{image}', [ProjectImageController::class, 'destroy'])->name('admin.projects.images.destroy');
    Route::post('/admin/projects/{project}/images/reorder', [ProjectImageController::class, 'reorder'])->name('admin.projects.images.reorder');

    Route::get('/admin/teams', [AdminTeamController::class, 'index'])->name('admin.teams.index');
    Route::get('/admin/teams/data', [AdminTeamController::class, 'data'])->name('admin.teams.data');
    Route::post('/admin/teams', [AdminTeamController::class, 'store'])->name('admin.teams.store');
    Route::get('/admin/teams/{team}', [AdminTeamController::class, 'show'])->name('admin.teams.show');
    Route::put('/admin/teams/{team}', [AdminTeamController::class, 'update'])->name('admin.teams.update');
    Route::delete('/admin/teams/{team}', [AdminTeamController::class, 'destroy'])->name('admin.teams.destroy');
    Route::post('/admin/teams/reorder', [AdminTeamController::class, 'reorder'])->name('admin.teams.reorder');

    Route::get('/admin/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/admin/contacts/data', [AdminContactController::class, 'data'])->name('admin.contacts.data');
    Route::get('/admin/contacts/{contact}', [AdminContactController::class, 'show'])->name('admin.contacts.show');
    Route::post('/admin/contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('admin.contacts.status');
    Route::delete('/admin/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/admin/contacts/export', [AdminContactController::class, 'export'])->name('admin.contacts.export');
});
