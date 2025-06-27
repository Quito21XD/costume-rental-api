<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class FilterScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // aplicar filtros
        if (empty(request('filters'))) {
            return;
        }
        $filters = request('filters');
        foreach ($filters as $field => $conditions) {
            foreach ($conditions as $condition => $value) {
                if (in_array($condition, ['=', '!=', '>', '<', '>=', '<='])) {
                    $builder->where($field, $condition, $value);
                }
                if ($condition == 'like') {
                    $builder->where($field, 'like', "%$value%");
                }
            }
        }
    }
}
