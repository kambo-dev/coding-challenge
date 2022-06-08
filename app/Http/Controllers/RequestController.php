<?php

namespace App\Http\Controllers;

use App\Enums\RequestStatuses;
use App\Helpers\ServiceResponse;
use App\Http\Requests\RequestCreateRequest;
use App\Http\Requests\RequestDeleteRequest;
use App\Http\Requests\RequestGetDataRequest;
use App\Http\Requests\RequestUpdateRequest;
use App\Models\User;
use App\Repositories\Contracts\RequestsEloquentRepositoryInterface;
use App\Repositories\Contracts\UserEloquentRepositoryInterface;
use App\Services\RequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    protected $requestRepository;
    protected $userRepository;

    public function __construct(
        RequestsEloquentRepositoryInterface $requestRepository,
        UserEloquentRepositoryInterface $userRepository
    ) {
        $this->requestRepository = $requestRepository;
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

    /**
     * Create new connection request between current $user and
     * the passed target user
     *
     * @param RequestCreateRequest $request
     * @return JsonResponse
     */
    public function store(RequestCreateRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $response = RequestService::store([
            'initiator_id' => $user->id,
            'target_id' => $request->target,
            'status' => RequestStatuses::SENT
        ]);

        return response()->json($response->toArray());
    }

    public function edit(Request $request, int $id)
    {
        //
    }

    /**
     * Update given connection request status,
     * than if the new status is 'accepted'
     * create a connection between connection request initiator and target
     * @todo delegate logic to service layer
     *
     * @param RequestUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(RequestUpdateRequest $request, int $id): JsonResponse
    {
        $requestModel = \App\Models\Request::query()
            ->with(['initiator', 'target'])
            ->findOrFail($id);

        $requestModel->update([
            'status' => $request->status
        ]);

        if ($requestModel->status === RequestStatuses::ACCEPTED) {
            $initiator = $requestModel->initiator;

            $initiator->connections()->attach($requestModel->target?->id, [
                'connected_at' => now()
            ]);
        }

        return response()->json((new ServiceResponse(true, $requestModel))->toArray());
    }

    /**
     * Soft delete the given connection request
     * @todo delegate logic to service layer
     *
     * @param RequestDeleteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function delete(RequestDeleteRequest $request, int $id): JsonResponse
    {
        $requestModel = \App\Models\Request::query()->findOrFail($id);

        $requestModel->delete();

        return response()->json((new ServiceResponse(true, $requestModel))->toArray());
    }

    /**
     * Get connection requests of current user
     * as rendered html in response['content']
     *
     * @param RequestGetDataRequest $request
     * @return JsonResponse
     */
    public function getData(RequestGetDataRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $requestsData = [];

        if ($request->type === 'sent') {
            $requestsData = $this->requestRepository
                ->getPaginatedUserSentRequests($user, RequestStatuses::SENT, $perPage);
        } elseif ($request->type === 'received') {
            $requestsData = $this->requestRepository
                ->getPaginatedUserReceivedRequests($user, RequestStatuses::SENT, $perPage);
        }

        $response = RequestService::getRequestsAsHtml($requestsData, $request->type);

        return response()->json($response->toArray());
    }

    /**
     * Get suggestions, connections, requests sent and received
     * count for current user
     * @todo delegate logic to service layer
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCounters(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        return response()->json((new ServiceResponse(true, data: [
            'count_suggestions' => $this->userRepository->countConnectionSuggestions($user),
            'count_sent' => $this->requestRepository->countUserSentRequests($user, RequestStatuses::SENT),
            'count_received' => $this->requestRepository->countUserReceivedRequests($user, RequestStatuses::SENT),
            'count_connections' => $this->userRepository->countUserConnections($user),
        ]))->toArray());
    }
}
