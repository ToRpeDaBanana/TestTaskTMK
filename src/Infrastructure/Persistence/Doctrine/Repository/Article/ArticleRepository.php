<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Article;

use App\Domain\Entity\Article\Article;
use App\Domain\Repository\Article\ArticleRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use DomainException;

class ArticleRepository implements ArticleRepositoryInterface
{
    private ObjectRepository $repository;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Article::class);
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id): Article
    {
        $article = $this->repository->find($id);
        if (!$article instanceof Article) {
            throw new DomainException('Article not found.');
        }

        return $article;
    }

    /**
     * @inheritDoc
     */
    public function save(Article $article): void
    {
        $this->em->persist($article);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function delete(Article $article): void
    {
        $this->em->remove($article);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function findAllActive(): array
    {
        return $this->repository->findBy(['isActive' => true]);
    }

    /**
     * @inheritDoc
     */
    public function findBySlug(string $slug): Article
    {
        $article = $this->repository->findOneBy(['slug' => $slug]);
        if (!$article instanceof Article) {
            throw new DomainException('Article not found.');
        }

        return $article;
    }
}
