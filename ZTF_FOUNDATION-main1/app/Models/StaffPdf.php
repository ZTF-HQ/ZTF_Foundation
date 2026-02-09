<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPdf extends Model
{
    protected $table="staffpdfs";
    protected $fillable=[
        'filename',
        'pdf_file',
        'user_id'
    ];
}
