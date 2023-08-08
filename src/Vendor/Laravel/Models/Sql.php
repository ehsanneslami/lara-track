<?php

namespace PragmaRX\Tracker\Vendor\Laravel\Models;

class Sql extends Base
{
    protected $table = 'tracker_sqls';

    protected $fillable = [
        'sha1',
        'statement',
        'time',
        'connection_id',
    ];
}
