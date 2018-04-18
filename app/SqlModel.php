<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SqlModel extends Model
{
    public const CREATED_AT = 'adTimeIns';

    public const UPDATED_AT = 'adTimeChg';

    protected $connection = 'sqlsrv';

    protected $primaryKey = 'anQId';

    protected $dateFormat = 'Y-m-d H:i:s.u';
}
