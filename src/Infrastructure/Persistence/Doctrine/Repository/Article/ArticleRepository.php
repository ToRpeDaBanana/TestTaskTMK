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
            throw new DomainException('Статья не найдена.');
        }

        return $article;
    }

    /**
     * @inheritDoc
     */
    public function save(Article $article): void
    {
        // Проверка на уникальность title и slug
        $this->checkForDuplicates($article);

        $this->em->persist($article);
        $this->em->flush();
    }

    /**
     * Проверка на наличие одинаковых title и slug
     *
     * @param Article $article
     * @throws DomainException
     */
    private function checkForDuplicates(Article $article): void
    {
        $existingArticleByTitle = $this->repository->findOneBy(['title' => $article->getTitle()]);
        if ($existingArticleByTitle) {
            throw new DomainException('Статья с таким заголовком уже существует.');
        }

        $existingArticleBySlug = $this->repository->findOneBy(['slug' => $article->getSlug()]);
        if ($existingArticleBySlug) {
            throw new DomainException('Статья с таким слугом уже существует.');
        }
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
    public function findBySlug(string $slug): Article
    {
        $article = $this->repository->findOneBy(['slug' => $slug]);
        if (!$article instanceof Article) {
            throw new DomainException('Статья не найдена.');
        }

        return $article;
    }

    public function findAllActive(int $page = 1, int $limit = 10): array
    {
        $queryBuilder = $this->em->createQueryBuilder();
        
        $queryBuilder->select('a')
                    ->from(Article::class, 'a')
                    ->where('a.isActive = :active')
                    ->setParameter('active', true)
                    ->setFirstResult(($page - 1) * $limit) // расчет начальной записи
                    ->setMaxResults($limit); // установка лимита

        return $queryBuilder->getQuery()->getResult();
    }

    public function countActiveArticles(): int
    {
        return (int)$this->em->createQueryBuilder()
            ->select('COUNT(a.id)')
            ->from(Article::class, 'a')
            ->where('a.isActive = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
