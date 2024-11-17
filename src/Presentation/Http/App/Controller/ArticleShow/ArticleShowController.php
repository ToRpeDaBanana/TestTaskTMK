<?php

declare(strict_types=1);

namespace App\Presentation\Http\App\Controller\ArticleShow;

use App\Application\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ArticleShowController extends AbstractController
{
    private ArticleService $articleService;
    
    // Конструктор для внедрения ArticleService
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    // Маршрут для отображения статьи по слагу
    #[Route(path: '/article/{slug}', name: "app_article_show")]
    public function show(string $slug): Response
    {
        try {
            // Получение статьи по слагу
            $article = $this->articleService->getArticleBySlug($slug);
        } catch (\RuntimeException $e) {
            // Обработка ошибок и редирект на список статей
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_article_list');
        }

        return $this->render('app/page/article/detail.html.twig', [
            'article' => $article,
        ]);
    }
}
