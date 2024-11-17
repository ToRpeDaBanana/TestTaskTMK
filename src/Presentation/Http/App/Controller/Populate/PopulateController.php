<?php

declare(strict_types=1);

namespace App\Presentation\Http\App\Controller\Populate;

use App\Application\Service\ArticlePopulationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class PopulateController extends AbstractController
{
    #[Route(path: '/populate', name: 'app_article_populate')]
    public function populate(Request $request,ArticlePopulationService $populationService): RedirectResponse
    {
        
        $randomArticles = $this->generateArticles(20); // Генерация 20 случайных статей

        try {
            $populationService->populateArticles($randomArticles); // Заполнение статей с помощью сервиса
            $this->addFlash('success', 'Статьи успешно добавлены!');
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());  // Обработка ошибок при заполнении
        }
        // Перенаправление на список статей
        $currentPage = $request->query->getInt('page', 1);
        return $this->redirectToRoute('app_article_list',['page' => $currentPage]); 
    }
    
    // Генерация случайных статей
    private function generateArticles(int $count = 20): array
    {
        $articles = [];

        for ($i = 1; $i <= $count; $i++) {
            $title = "Статья номер $i";
            $slug = "statya-nomer-$i";
            $views = rand(0, 50000000);
            $description = "Описание статьи номер $i.";

            $articles[] = [
                'title' => $title,
                'slug' => $slug,
                'views' => $views,
                'description' => $description,
            ];
        }

        return $articles;
    }
}
