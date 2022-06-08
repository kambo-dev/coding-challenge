<?php


namespace App\Http\Controllers;


use App\Helpers\ServiceResponse;
use App\Http\Requests\UserGetSuggestionsRequest;
use App\Models\User;
use App\Repositories\Contracts\UserEloquentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserEloquentRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        //
    }

    public function show(Request $request, int $id)
    {
        //
    }

    public function create(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Request $request, int $id)
    {
        //
    }

    public function update(Request $request, int $id)
    {
        //
    }

    public function delete(Request $request, int $id)
    {
        //
    }

    /**
     * Get all connections of current user
     * @todo - implement
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getConnections(Request $request)
    {

    }

    /**
     * Create new connection(s) between current user and
     * the passed user(s)
     * @todo - implement
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function connectionsAttach(Request $request)
    {

    }

    /**
     * Get connection suggestions of current user
     * as rendered html in response['content']
     * @todo delegate logic to service layer
     *
     * @param UserGetSuggestionsRequest $request
     * @return JsonResponse
     */
    public function getSuggestions(UserGetSuggestionsRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        $suggestions = $this->userRepository
            ->getPaginatedConnectionSuggestions($user, $perPage);

        $response = '';
        foreach ($suggestions as $suggestion) {
            $response .= view('components.suggestion', [
                'connection' => $suggestion,
                'user' => $user
            ])->render();
        }

        if ($suggestions instanceof LengthAwarePaginator && $suggestions->hasMorePages()) {
            $response .= view('components.load_more', [
                'loadMoreHandler' => "getMoreSuggestions()",
                'nextPage' => $suggestions->nextPageUrl()
            ])->render();
        }

        return response()->json((new ServiceResponse(true, data: [
            'content' => $response,
            'count' => $suggestions->total()
        ]))->toArray());
    }
}
