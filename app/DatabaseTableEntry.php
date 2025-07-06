<?php

namespace App;

use Illuminate\Support\Facades\DB;

class DatabaseTableEntry
{
    public array $model;
    public int $id;

    /**
     * Create a new class instance.
     */
    public function __construct(string $tablename, ?int $id)
    {  
        try {     
            $entry = DB::table($tablename)->where('id', '=', $id)->firstOrFail();
        } catch (\Throwable $th) {
            
        }
        $columns = DB::connection()->getSchemaBuilder()->getColumnListing($tablename);
        
        foreach ($columns as $column) {
            $datatype = DB::connection()->getSchemaBuilder()->getColumnType($tablename, $column);
            $model[] = [
                'label' => $column,
                'value' => $entry->$column ?? null,
                'datatype' => $datatype
            ];
        }
        
        $this->id = $id;
        $this->model = $model;
    }
}
