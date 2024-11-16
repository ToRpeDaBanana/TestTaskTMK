<?php


declare(strict_types=1);

namespace App\Presentation\Http\App\Controller\Frontpage;

use App\Domain\Repository\Article\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: 'app_frontpage')]
class FrontpageController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function __invoke(): Response
    {
        $articles = $this->articleRepository->findAll(); // Получение всех статей

        return $this->render('app/page/frontpage/page.html.twig', [
            'articles' => $articles,
        ]);
    }
}
