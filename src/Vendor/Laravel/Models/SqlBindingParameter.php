<?php

namespace PragmaRX\Tracker\Vendor\Laravel\Models;

class SqlBindingParameter extends Base
{
    protected $table = 'tracker_sql_bindings_parameters';

    protected $fillable = [
        'sql_bindings_id',
        'name',
        'value',
    ];
}
