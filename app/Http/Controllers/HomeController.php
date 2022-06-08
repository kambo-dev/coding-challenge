<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\RequestsEloquentRepositoryInterface;
use App\Repositories\Contracts\UserEloquentRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $requestsRepository;
    protected $usersRepository;

    /**
     * Create a new controller instance.
     *
     * @param RequestsEloquentRepositoryInterface $requestsRepository
     * @param UserEloquentRepositoryInterface $userRepository
     */
    public function __construct(
        RequestsEloquentRepositoryInterface $requestsRepository,
        UserEloquentRepositoryInterface $userRepository
    ) {
        $this->requestsRepository = $requestsRepository;
        $this->usersRepository = $userRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $connectionSuggestions = $this->usersRepository
            ->getPaginatedConnectionSuggestions($user);

        $connectionSuggestionsCount = $connectionSuggestions->count();

        return view('home', compact(
            'connectionSuggestions',
            'connectionSuggestionsCount'
        ));
    }
}
