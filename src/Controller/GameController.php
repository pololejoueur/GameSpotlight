// src/Controller/GameController.php

namespace App\Controller;

use App\Service\CheapSharkApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct(private CheapSharkApiService $apiService) {}

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $deals = $this->apiService->getTopDeals();

        return $this->render('home.html.twig', [
            'deals' => $deals,
        ]);
    }

    #[Route('/search/{title}', name: 'search')]
    public function search(string $title): Response
    {
        $games = $this->apiService->searchGames($title);

        return $this->render('search.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/game/{id}', name: 'game_detail')]
    public function detail(string $id): Response
    {
        $game = $this->apiService->getGameDetails($id);

        return $this->render('detail.html.twig', [
            'game' => $game,
        ]);
    }
}
