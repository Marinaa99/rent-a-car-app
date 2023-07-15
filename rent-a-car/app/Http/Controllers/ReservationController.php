<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;

use App\Http\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Carbon\Carbon;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function store(StoreReservationRequest $request)
    {
        $validatedData = $request->validated();

        try {
            $reservation = $this->reservationService->store($validatedData);

            return response()->json(['data' => $reservation], ResponseAlias::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], ResponseAlias::HTTP_BAD_REQUEST);
        }
    }


    public function destroy($id)
    {


        $this->reservationService->deleteReservation($id);

        return response(['message' => 'Reservation deleted'], ResponseAlias::HTTP_OK);
    }

    public function index(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $start = $start ? Carbon::parse($start) : null;
        $end = $end ? Carbon::parse($end) : null;

        $reservations = $this->reservationService->getAllReservations($start, $end);

        return response(['data' => ReservationResource::collection($reservations)], ResponseAlias::HTTP_OK);
    }

    public function show($id)
    {
        $reservation = $this->reservationService->getReservationById($id);

        if (!$reservation) {
            return response(['message' => 'Reservation not found.'], ResponseAlias::HTTP_NOT_FOUND);
        }

        return response(['data' => new ReservationResource($reservation)], ResponseAlias::HTTP_OK);
    }


    public function update(UpdateReservationRequest $request, $id)
    {
        $validatedData = $request->validated();

        $reservation = $this->reservationService->updateReservation($id, $validatedData);

        return response(['data' => new ReservationResource($reservation)], ResponseAlias::HTTP_OK);
    }

    public function exportExcel(Request $request)
    {
        $export = $this->reservationService->exportExcel($request);

        if(!$export)
            return response(['message' => 'No reservations with given criteria'], ResponseAlias::HTTP_BAD_REQUEST);
        return $export;
    }

}
