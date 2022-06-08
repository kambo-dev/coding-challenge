<?php


namespace App\Services;


use App\Helpers\ServiceResponse;
use App\Models\Request;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequestService
{
    public static function store(array $data): ServiceResponse
    {
        try {
            DB::beginTransaction();

            $request = Request::create($data);

            DB::commit();

            return new ServiceResponse(true, $request, "Request created");

        } catch (Exception $exception) {
            DB::rollBack();
            Log::error("RequestService@store ".$exception->getMessage());
            Log::error($exception->getTraceAsString());

            return new ServiceResponse(false, message: "Something went wrong!");
        }
    }

    public static function getRequestsAsHtml($requests, string $type): ServiceResponse
    {
        try {
            $response = '';
            foreach ($requests as $request) {
                $response .= view('components.request', [
                    'mode' => $type,
                    'request' => $request
                ])->render();
            }

            if ($requests instanceof LengthAwarePaginator && $requests->hasMorePages()) {
                $response .= view('components.load_more', [
                    'loadMoreHandler' => "getMoreRequests('$type')",
                    'nextPage' => $requests->nextPageUrl()
                ])->render();
            }

            return new ServiceResponse(true, data: [
                'content' => $response,
                'count' => $requests->total()
            ]);

        } catch (Exception $exception) {
            Log::error("RequestService@getRequestsAsHtml ".$exception->getMessage());
            Log::error($exception->getTraceAsString());

            return new ServiceResponse(false, message: "Something went wrong!");
        }
    }
}
