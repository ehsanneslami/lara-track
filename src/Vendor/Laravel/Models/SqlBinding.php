<?php

namespace PragmaRX\Tracker\Vendor\Laravel\Models;

class SqlBinding extends Base
{
    protected $table = 'tracker_sql_bindings';

    protected $fillable = [
        'sha1',
        'serialized',
    ];
}
