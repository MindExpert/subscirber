<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    public function active(): PostQueryBuilder
    {
        return $this->where('status', true);
    }

    public function search(?string $keyword = null): PostQueryBuilder
    {
        $query = $this;

        $keywords = explode(' ', $keyword);

        if (($key = array_search('-', $keywords)) !== false) {
            unset($keywords[$key]);
        }

        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query
                    ->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%");
            });
        }

        return $query->limit(15);
    }
}
