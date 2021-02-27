<?php

namespace App\Models\Traits;

use App\Models\Team;
use App\Models\Scopes\BelongsToTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TeamTenant
{
    
    /**
     * bootTeamTenant
     * Ao criar contato verifica se possuim um team_id, caso não, atribui o id do team autenticado.
     *
     * @return void
     */
    public static function bootTeamTenant(): void
    {
        static::creating(function (Model $model) {
            if (! $model->team_id) {
                $model->team_id = Auth::user()->currentTeam->id;
            }
        });

        static::addGlobalScope(new BelongsToTeam());
    }
    
    /**
     * team
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}