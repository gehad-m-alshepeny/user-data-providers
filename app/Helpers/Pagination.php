<?php

namespace App\Helpers;

class Pagination
{
    
    public function paginate(array $items, int $page, int $perPage): array
    {
        // Get the total number of items
        $total = count($items);
        
        // Calculate the start index of the items for the current page
        $start = ($page - 1) * $perPage;

        // Slice the data array to return only the items for the current page
        $paginatedItems = array_slice($items, $start, $perPage);

        // Prepare pagination meta-data
        $pagination = [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'from' => $start + 1,
            'to' => $start + count($paginatedItems),
        ];

        return [
            'data' => $paginatedItems,
            'pagination' => $pagination,
        ];
    }
}
