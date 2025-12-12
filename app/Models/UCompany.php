<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UCompany extends Model
{
    use HasFactory;

    protected $table = 'u_companies';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_name',
        'rep_fname',
        'rep_lname',
        'rep_email',
        'rep_mobile',
        'rep_gender',
        'owner_fname',
        'owner_lname',
        'owner_gender',
        'owner_email',
        'same_rep_owner',
        'company_size',
        'company_direct_workers',
        'company_indirect_workers',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }

    public function address()
    {
        return $this->morphOne(UAddress::class, 'ownerable')->latestOfMany();
        // return $this->morphMany(UAddress::class, 'ownerable');
    }

    public function addressLatest()
    {
        return $this->morphOne(UAddress::class, 'ownerable')->latestOfMany();
    }

    public function numContacts()
    {
        return $this->morphMany(UNumContact::class, 'ownerable');
    }
}
