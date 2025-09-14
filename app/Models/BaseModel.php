<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

abstract class BaseModel extends Model
{
    use LogsActivity;
}
