<?php
namespace App\Controller;

use App\Service\CheapSharkApiService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct(private CheapSharkApiService $apiService) {}

    #[Route('/', name: 'home')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $deals = $this->apiService->getTopDeals();
        $pagination = $paginator->paginate($deals, $request->query->getInt('page', 1), 10);

        return $this->render('home.html.twig', [
            'deals' => $pagination,
        ]);
    }

    #[Route('/search/{title}', name: 'search')]
    public function search(string $title, Request $request, PaginatorInterface $paginator): Response
    {
        $games = $this->apiService->searchGames($title);
        $pagination = $paginator->paginate($games, $request->query->getInt('page', 1), 10);

        return $this->render('search.html.twig', [
            'games' => $pagination,
        ]);
    }
}
