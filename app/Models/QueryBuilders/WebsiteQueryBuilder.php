<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class WebsiteQueryBuilder extends Builder
{
    public function active(): WebsiteQueryBuilder
    {
        return $this->where('status', true);
    }

    public function search(?string $keyword = null): WebsiteQueryBuilder
    {
        $query = $this;

        if ($keyword === null) {
            return $query->limit(15);
        }

        if ($keyword == null) {
            return $query->limit(15);
        }

        $keywords = explode(' ', $keyword);

        if (($key = array_search('-', $keywords)) !== false) {
            unset($keywords[$key]);
        }

        foreach ($keywords as $keyword) {
            $query = $query->where(function (Builder $query) use ($keyword) {
                return $query
                    ->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('url', 'LIKE', "%$keyword%");
            });
        }

        return $query->limit(15);
    }
}
