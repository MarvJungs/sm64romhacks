<?php

use App\DatabaseTable;
use App\DatabaseTableEntry;
use App\Http\Controllers\NewspostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get(
    'moderation', function () {
        $tables = DB::connection()->getSchemaBuilder()->getTables(env('DB_DATABASE'));
        return view('moderation.index')->with('tables', $tables);
    }
);

Route::get(
    'moderation/newsposts', function () {
        return view('moderation.newsposts.index');
    }
);

Route::get('news/manage/{newspost?}', [NewspostsController::class, 'manage'])->name('newspost.manage');
Route::post('news/manage/{newspost?}', [NewspostsController::class, 'store'])->name('newspost.store');
Route::get('news/{newspost}/delete', [NewspostsController::class, 'delete'])->name('newspost.delete');
Route::delete('news/{newspost}/delete', [NewspostsController::class, 'destroy'])->name('newspost.destroy');

Route::get(
    'tables', function () {
        $tables = DB::connection()->getSchemaBuilder()->getTables(env('DB_DATABASE'));
        return view('db.tables')->with('tables', $tables);
    }
);

Route::get(
    'tables/{name}', function (string $name) {
        try {
            $table = new DatabaseTable($name);
            return view('db.table-detail')->with('table', $table);
        } catch (\Throwable $th) {
            abort(500);
        }
    }
);

Route::get(
    'tables/{name}/edit/{id}', function (string $name, int $id) {
        $dbentry = new DatabaseTableEntry($name, $id);
        $model = $dbentry->model;
        return view('db.table-edit-model')->with('model', $model);
    }
);

Route::get(
    'tables/{name}/create', function (string $name) {
        $dbentry = new DatabaseTableEntry($name, null);
        $model = $dbentry->model;
        return view('db.table-edit-model')->with('model', $model);
    }
);

Route::post(
    'tables/{name}', function (Request $request, string $name) {
        DB::table($name)->insert($request->all());
    }
);

Route::put(
    'tables/{name}/{id}', function (Request $request, string $name, int $id) {
        DB::table($name)->update($request->all());
    }
);
