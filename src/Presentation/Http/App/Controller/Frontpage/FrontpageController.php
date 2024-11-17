<?php

declare(strict_types=1);

namespace App\Presentation\Http\App\Controller\Frontpage;

use App\Application\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontpageController extends AbstractController
{
    private ArticleService $articleService;
    // Конструктор для внедрения ArticleService
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    // Маршрут для отображения списка статей с постраничной навигацией
    #[Route(path: '/{page}', name: 'app_article_list', requirements: ['page' => '\d+'])]
    public function list(int $page = 1): Response
    {
        if ($page === null) {
            $page = 1; // Присваиваем значение по умолчанию
        }
        try {
            // Получаем активные статьи и общее количество
            $articles = $this->articleService->getAllActiveArticles($page);
            $totalArticles = $this->articleService->getActiveArticlesCount();
            $totalPages = ceil($totalArticles / 10); // Расчет общего количества страниц
        } catch (\RuntimeException $e) {
            // Обработка ошибок и установка значений по умолчанию
            $this->addFlash('error', $e->getMessage());
            $articles = [];
            $totalPages = 1; // Необходимо, чтобы избежать ошибок при выводе страниц
        }

        return $this->render('app/page/frontpage/page.html.twig', [
            'articles' => $articles,
            'current_page' => $page,
            'total_pages' => $totalPages,
        ]);
    }
}
