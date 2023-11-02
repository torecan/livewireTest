<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Type\Integer;

class Todo extends Model
{


    protected $fillable = ['description', 'done'];

    use HasFactory;


    public function scopeByFilteredUncompleted(Builder $query) :Builder {
        return $query->whereNull('done');
    }
    public function scopeByFilteredCompleted(Builder $query) :Builder {
        return $query->where('done', 1);
    }

    public function scopeUncheckItem(Builder $query, Request $request) :Builder {

        dd($request);

        $item = $query->find($id);

        dd($item);
        $item->update(['done', null]);
        $item->update([$id, 12]);

        return $query->where('done', 1);
    }

    public function scopeSearchItem(Builder $query, $str) :Builder {

        return $query->where('description', 'like',
       "%$str%");
    }

}
