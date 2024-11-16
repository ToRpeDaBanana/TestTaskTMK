<?php

namespace App\Infrastructure\Persistence\Doctrine\Repository\Article;

use App\Domain\Entity\Article\Article;
use App\Domain\Repository\Article\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use DomainException;

class DoctrineArticleRepository implements ArticleRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $entityManager->getRepository(Article::class);
    }

    public function findAll(): array
    {
        // return $this->entityManager->getRepository(Article::class)->findAll();
        $article = $this->objectRepository->findAll();
        if (!$article instanceof Article) {
            throw new DomainException('Article not found.');
        }

        return $article;
    }

    public function findBySlug(string $slug): ?Article
    {
        return $this->entityManager->getRepository(Article::class)->findOneBy(['slug' => $slug]);
    }

    public function findById(int $id): ?Article
    {
        return $this->objectRepository->find($id);
    }

    public function save(Article $article): void
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    public function delete(Article $article): void
    {
        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

}
