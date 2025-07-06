<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseTable
{
    public string $name;
    public array $header;
    public Collection $rows;
    public string $model;
    
    /**
     * Create a new class instance.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->model = "App\Models\\" . Str::studly(Str::singular($name));
        $this->header = DB::connection()->getSchemaBuilder()->getColumnListing($name);
        $this->rows = DB::table($name)->get();
    }
}
