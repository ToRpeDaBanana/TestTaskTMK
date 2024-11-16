<?php

declare(strict_types=1);

namespace App\Domain\Repository\Article;

use App\Domain\Entity\Article\Article;
use DomainException;

interface ArticleRepositoryInterface
{
    /**
     * Найти статью по ID
     *
     * @param int $id
     *
     * @return Article
     *
     * @throws DomainException
     */
    public function findById(int $id): Article;

    /**
     * Сохранить статью
     *
     * @param Article $article
     *
     * @return void
     */
    public function save(Article $article): void;

    /**
     * Удалить статью
     *
     * @param Article $article
     *
     * @return void
     */
    public function delete(Article $article): void;

    /**
     * Найти все активные статьи
     *
     * @return Article[]
     */
    public function findAllActive(): array;

    /**
     * Найти по уникальной ссылке
     */
    public function findBySlug(string $slug): Article;
}
