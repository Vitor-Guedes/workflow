<?php

namespace App\Models;

use App\Traits\DB;
use App\Workflows\CustomerWorkflow;

class Customer
{
    use DB;

    public $workflow = CustomerWorkflow::class;

    protected $table = 'customers';

    public $id;

    public $name;

    public $email;

    protected $fillable = [
        'name',
        'email'
    ];
}