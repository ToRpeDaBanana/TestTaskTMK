<?php

namespace App\Application\Service;

use App\Domain\Entity\Article\Article;
use App\Domain\Repository\Article\ArticleRepository;

class ArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function createArticle(string $title, string $slug, string $description): Article
    {
        $article = new Article($title, $slug, $description, true, 0);
        $this->articleRepository->save($article);
    
        return $article;
    }

    public function getArticleBySlug(string $slug): ?Article
    {
        return $this->articleRepository->findBySlug($slug);
    }

    public function getAllArticles(): array
    {
        return $this->articleRepository->findAll();
    }
}
