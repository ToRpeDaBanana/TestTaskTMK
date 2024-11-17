<?php

namespace App\Application\Service;

use App\Domain\Entity\Article\Article;
use App\Domain\Repository\Article\ArticleRepositoryInterface;
use DomainException;

class ArticlePopulationService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function populateArticles(array $randomArticles): void
    {
        foreach ($randomArticles as $articleData) {

            try {
                $article = new Article(
                    $articleData['title'],
                    $articleData['slug'],
                    $articleData['description'],
                    true, // Активная по умолчанию
                    $articleData['views']
                );
                $this->articleRepository->save($article);
            } catch (DomainException $e) {
                throw new \RuntimeException('Не удалось сохранить статью: ' . $e->getMessage());
            }
        }
    }
}
