<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CheatcodesController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\NewspostsController;
use App\Http\Controllers\RomhackCommentsController;
use App\Http\Controllers\RomhackeventsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\RomhacksController;
use App\Http\Controllers\RomhackTagsController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckRole;
use App\Models\Author;
use App\Models\Cheatcode;
use App\Models\Comment;
use Illuminate\Support\Facades\Route;
use App\Models\Newspost;
use App\Models\Role;
use App\Models\Romhackevent;
use App\Models\Romhacktag;
use App\Models\User;

Route::prefix('admin')->group(
    function () {
        Route::get('', [ModerationController::class, 'index'])->name('admin.index')->middleware(CheckRole::class . ':owner');

        Route::prefix('authors')->group(
            function () {
                Route::get('', [AuthorController::class, 'index'])->name('admin.authors.index')->can('viewAny', Author::class);
                Route::get('{author}/edit', [AuthorController::class, 'edit'])->name('admin.authors.edit')->can('update', 'author');
                Route::put('{author}/edit', [AuthorController::class, 'update'])->name('admin.authors.update')->can('update', 'author');
                Route::delete('{author}/delete', [AuthorController::class, 'destroy'])->name('admin.authors.destroy')->can('delete', 'author');
                Route::get('{author}/user', [AuthorController::class, 'setUser'])->name('admin.authors.setUser')->can('setUser', 'author');
                Route::post('{author}/user', [AuthorController::class, 'updateUser'])->name('admin.authors.updateUser')->can('setUser', 'author');
            }
        );

        Route::get('comments', [RomhackCommentsController::class, 'index'])->name('admin.comments.index')->can('viewAny', Comment::class);

        Route::prefix('cheats')->group(
            function () {
                Route::get('create', [CheatcodesController::class, 'create'])->name('admin.cheats.create')->can('create', Cheatcode::class);
                Route::post('create', [CheatcodesController::class, 'store'])->name('admin.cheats.store')->can('create', Cheatcode::class);
                Route::get('{cheatcode}/edit', [CheatcodesController::class, 'edit'])->name('admin.cheats.edit')->can('update', 'cheatcode');
                Route::put('{cheatcode}/edit', [CheatcodesController::class, 'update'])->name('admin.cheats.update')->can('update', 'cheatcode');
                Route::delete('{cheatcode}/delete', [CheatcodesController::class, 'destroy'])->name('admin.cheats.destroy')->can('delete', 'cheatcode');
            }
        );

        Route::prefix('roles')->group(
            function () {
                Route::get('', [RolesController::class, 'index'])->name('admin.roles.index')->can('viewAny', Role::class);
                Route::get('create', [RolesController::class, 'create'])->name('admin.roles.create')->can('create', Role::class);
                Route::post('create', [RolesController::class, 'store'])->name('admin.roles.store')->can('create', Role::class);
                Route::get('{role}/edit', [RolesController::class, 'edit'])->name('admin.roles.edit')->can('update', 'role');
                Route::put('{role}/edit', [RolesController::class, 'update'])->name('admin.roles.update')->can('update', 'role');
                Route::delete('{role}/delete', [RolesController::class, 'destroy'])->name('admin.roles.destroy')->can('delete', 'role');
            }
        );

        Route::prefix('tags')->group(
            function () {
                Route::get('', [RomhackTagsController::class, 'index'])->name('admin.romhacktags.index')->can('viewAny', Romhacktag::class);
                Route::get('{tag}/edit', [RomhackTagsController::class, 'edit'])->name('admin.romhacktags.edit')->can('update', 'tag');
                Route::put('{tag}/edit', [RomhackTagsController::class, 'update'])->name('admin.romhacktags.update')->can('update', 'tag');
                Route::delete('{tag}/delete', [RomhackTagsController::class, 'destroy'])->name('admin.romhacktags.destroy')->can('delete', 'tag');
            }
        );

        Route::prefix('users')->group(
            function () {
                Route::get('', [UsersController::class, 'index'])->name('admin.users.index')->can('viewAny', User::class);
                Route::delete('{user}/delete', [UsersController::class, 'destroy'])->name('admin.users.destroy')->can('delete', 'user');
                Route::get('{user}/roles', [UsersController::class, 'roles'])->name('admin.users.roles')->can('assignRole', 'user');
                Route::post('{user}/roles', [UsersController::class, 'setRoles'])->name('admin.users.setRoles')->can('assignRole', 'user');
            }
        );
    }
);


Route::prefix('news')->group(
    function () {
        Route::get('create', [NewspostsController::class, 'create'])->name('newspost.create')->can('create', Newspost::class);
        Route::post('create', [NewspostsController::class, 'store'])->name('newspost.store')->can('create', Newspost::class);
        Route::get('{newspost}/edit', [NewspostsController::class, 'edit'])->name('newspost.edit')->can('update', 'newspost');
        Route::put('{newspost}/edit', [NewspostsController::class, 'update'])->name('newspost.update')->can('update', 'newspost');
        Route::delete('{newspost}/delete', [NewspostsController::class, 'destroy'])->name('newspost.destroy')->can('delete', 'newspost');
    }
);

Route::prefix('modhub')->group(
    function () {
        Route::get('hacks', [RomhacksController::class, 'modhub'])->name('modhub.hacks.index')->middleware(CheckRole::class . ':admin,moderator');
        Route::post('hacks/{hack}/verify', [RomhacksController::class, 'verify'])->name('modhub.hacks.verify')->can('verify', 'hack');
        Route::post('hacks/{hack}/reject', [RomhacksController::class, 'reject'])->name('modhub.hacks.reject')->can('reject', 'hack');
    }
);

Route::prefix('events')->group(
    function () {
        Route::get('', [RomhackeventsController::class, 'index'])->name('events.index')->can('viewAny', Romhackevent::class);
        Route::get('create', [RomhackeventsController::class, 'create'])->name('event.create')->can('create', Romhackevent::class);
        Route::post('create', [RomhackeventsController::class, 'store'])->name('event.store')->can('create', Romhackevent::class);
        Route::get('{event}/edit', [RomhackeventsController::class, 'edit'])->name('event.edit')->can('update', 'event');
        Route::put('{event}/edit', [RomhackeventsController::class, 'update'])->name('event.update')->can('update', 'event');
        Route::delete('{event}/delete', [RomhackeventsController::class, 'destroy'])->name('event.destroy')->can('delete', 'event');
    }
);
