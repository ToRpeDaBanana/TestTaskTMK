<?php

namespace App\Domain\Repository\Article;

use App\Domain\Entity\Article\Article;

interface ArticleRepository
{
    public function findById(int $id): ?Article; // Поиск по ID

    public function save(Article $article): void; // Сохранение сущности

    public function delete(Article $article): void; // Удаление сущности

    public function findAll(): array;
    public function findBySlug(string $slug): ?Article;
}
