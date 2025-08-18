<?php

namespace App\Models;

use PDO;

class SearchModel
{
  public function __construct(private PDO $pdo) {}

  public function findSubcategories(string $q, string $qLike): array
  {
    $sql = "
          SELECT s.name, s.subcategory_slug AS slug, c.slug AS category_slug
          FROM subcategories s
          JOIN categories c ON c.category_id = s.category_id
          WHERE s.name LIKE :q OR s.subcategory_slug LIKE :q
          ORDER BY CASE WHEN s.name = :qExact OR s.subcategory_slug = :qExact THEN 0 ELSE 1 END, s.name
          LIMIT 5
        ";

    return $this->run($sql, [':q' => $qLike, ':qExact' => $q]);
  }

  public function findCategories(string $q, string $qLike): array
  {
    $sql = "
          SELECT c.name, c.slug
          FROM categories c
          WHERE c.name LIKE :q OR c.slug LIKE :q
          ORDER BY CASE WHEN c.name = :qExact OR c.slug = :qExact THEN 0 ELSE 1 END, c.name
          LIMIT 5
        ";

    return $this->run($sql, [':q' => $qLike, ':qExact' => $q]);
  }

  public function findProducts(string $q, string $qLike): array
  {
    $sql = "
          SELECT p.name, p.slug, c.slug AS category_slug
          FROM products p
          JOIN subcategories s ON s.subcategory_id = p.subcategory_id
          JOIN categories c ON c.category_id = s.category_id
          WHERE p.name LIKE :q
          ORDER BY CASE WHEN p.name = :qExact THEN 0 ELSE 1 END, p.name
          LIMIT 10
        ";

    return $this->run($sql, [':q' => $qLike, ':qExact' => $q]);
  }

  private function run(string $sql, array $params): array
  {
    $st = $this->pdo->prepare($sql);
    foreach ($params as $k => $v) {
      $st->bindValue($k, $v, PDO::PARAM_STR);
    }
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
  }
}
