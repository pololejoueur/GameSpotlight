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

    // Ajouter le champ imageUrl pour chaque deal
    $deals = array_map(function ($deal) {
        $deal['imageUrl'] = $deal['thumb'];
        return $deal;
    }, $deals);

    $pagination = $paginator->paginate($deals, $request->query->getInt('page', 1), 10);

    return $this->render('home.html.twig', [
        'deals' => $pagination,
    ]);
    }
}
