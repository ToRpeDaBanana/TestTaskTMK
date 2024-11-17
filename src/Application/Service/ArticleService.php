<?php

namespace App\Application\Service;

use App\Domain\Repository\Article\ArticleRepositoryInterface;
use DomainException;
use App\Domain\Entity\Article\Article;

class ArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAllActiveArticles(int $page = 1, int $limit = 10): array
{
    try {
        return $this->articleRepository->findAllActive($page, $limit);
    } catch (DomainException $e) {
        throw new \RuntimeException('Не удалось получить статьи.');
    }
}


    public function getArticleBySlug(string $slug): Article
    {
        try {
            return $this->articleRepository->findBySlug($slug);
        } catch (DomainException $e) {
            throw new \RuntimeException('Статья не найдена.');
        }
    }

    public function saveArticle(string $title, string $slug, string $description): void
    {
        $article = new Article($title, $slug, $description);
        $this->articleRepository->save($article);
    }
    public function getActiveArticlesCount(): int
{
    return $this->articleRepository->countActiveArticles();
}
}
