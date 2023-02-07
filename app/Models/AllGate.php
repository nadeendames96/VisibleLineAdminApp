<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllGate extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'all_gates';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'gates_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function gateNameAds()
    {
        return $this->hasMany(Ad::class, 'gate_name_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
