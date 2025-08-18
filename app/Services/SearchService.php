<?php

namespace App\Services;

use App\Models\SearchModel;
use PDO;

class SearchService
{
    private SearchModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new SearchModel($pdo);
    }

    public function suggestions(string $q): array
    {
        $qLike = '%' . $q . '%';

        // 1) Subcategories
        $sub = $this->model->findSubcategories($q, $qLike);
        $sub = array_map(fn($r) => [
            'type' => 'subcategory',
            'name' => $r['name'],
            'category_slug' => $r['category_slug'],
            'url'  => "/products/{$r['category_slug']}/{$r['slug']}",
        ], $sub);

        // 2) Categories
        $cat = $this->model->findCategories($q, $qLike);
        $cat = array_map(fn($r) => [
            'type' => 'category',
            'name' => $r['name'],
            'slug' => $r['slug'],
            'url'  => "/products/{$r['slug']}",
        ], $cat);

        // 3) Products
        $prod = $this->model->findProducts($q, $qLike);
        $prod = array_map(fn($r) => [
            'type' => 'product',
            'name' => $r['name'],
            'slug' => $r['slug'],
            'category_slug' => $r['category_slug'],
            'url'  => "/detail/{$r['slug']}",
        ], $prod);

        // Ưu tiên: subcategory → category → product
        return array_values($this->uniqueByUrl(array_merge($sub, $cat, $prod)));
    }

    private function uniqueByUrl(array $rows): array
    {
        $seen = [];
        return array_values(array_filter($rows, function ($r) use (&$seen) {
            if (isset($seen[$r['url']])) return false;
            $seen[$r['url']] = true;
            return true;
        }));
    }
}
