<?php

namespace App\Http\Controllers;

use App\Exports\ReservationExport;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;

use App\Http\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($reservations->isEmpty()) {
            return response(['message' => 'No reservations'], ResponseAlias::HTTP_OK);
        }
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
        $criteria = $request->all();

        $reservations = $this->reservationService->getFilteredReservations($criteria);

        return Excel::download(new ReservationExport($reservations), 'reservations.xlsx');
    }

}
