<?php

declare(strict_types=1);

namespace App\Presentation\Http\App\Controller\Frontpage;

use App\Domain\Repository\Article\ArticleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Domain\Entity\Article\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FrontpageController extends AbstractController
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route(path: '/', name: 'app_article_list')]
    public function list(): Response
    {
        // Получение всех активных статей
        $articles = $this->articleRepository->findAllActive();

        // Передача статей в шаблон
        return $this->render('app/page/frontpage/page.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route(path: '/article/{slug}', name: "app_article_show")]
    public function show(string $slug): Response
    {
        $article = $this->articleRepository->findBySlug($slug);
        return $this->render('app/page/article/detail.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route(path: '/populate', name: 'app_article_populate')]
    public function populate(): RedirectResponse
    {
        $staticArticles = [
            ['title' => 'First Article', 'slug' => 'first-article', 'description' => 'Description for the first article.'],
            ['title' => 'Second Article', 'slug' => 'second-article', 'description' => 'Description for the second article.'],
            // Добавьте другие статьи по аналогии
        ];

        foreach ($staticArticles as $data) {
            $article = new Article(
                $data['title'],
                $data['slug'],
                $data['description']
            );
            $this->articleRepository->save($article);
        }

        // Перенаправление на страницу списка статей после вставки
        return $this->redirectToRoute('app_article_list');
    }
}
