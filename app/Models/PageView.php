<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'visitor_hash',
        'path',
        'referrer_host',
        'visited_on',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'visited_on' => 'date',
        ];
    }
}
