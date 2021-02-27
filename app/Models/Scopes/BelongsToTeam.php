<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class BelongsToTeam implements Scope
{    
    /**
     * apply
     *
     * Só exibe contatos vinculados ao team autenticado.
     * 
     * @param  mixed $builder
     * @param  mixed $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('team_id', Auth::user()->currentTeam->id);
    }
}