<?php
namespace APP\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Sample extends Model
{
    public $timestamps = false;
    protected $connection = 'sqlite';

    //Eloquent wants to use plural for table names, override this below:
    //name of table if different than class name...
    protected $table = 'Sample';
}
