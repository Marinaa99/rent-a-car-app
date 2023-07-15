<?php

namespace app\Http\Services;
use App\Mail\CarReservationMail;
use App\Models\Reservation;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class  ReservationService

{
    public function store(array $validatedData): Reservation
    {
        $carId = $validatedData['car_id'];
        $pickupDate = $validatedData['pickup_date'];
        $returnDate = $validatedData['return_date'];
        $userId = Auth::id();


        $isDateAvailable = $this->isDateAvailableForCar($carId, $pickupDate, $returnDate);

        if (!$isDateAvailable) {
            throw new \Exception('Car is not available for the selected dates.');
        }

        $reservation = Reservation::create([
            'car_id' => $carId,
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'user_id' => $userId,
        ]);
        Mail::to(auth()->user()->email)->queue(new CarReservationMail($reservation->car));
        return $reservation;
    }

    private function  isDateAvailableForCar(int $carId, string $pickupDate, string $returnDate): bool
    {
        $existingReservation = Reservation::where('car_id', $carId)
            ->where(function ($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                    ->orWhereBetween('return_date', [$pickupDate, $returnDate]);
            })
            ->exists();

        return !$existingReservation;
    }


    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
    }

    public function getAllReservations(?Carbon $start = null, ?Carbon $end = null)
    {
        $query = Reservation::query();

        if ($start && $end) {
            $query->whereBetween('pickup_date', [$start, $end])
                ->orWhereBetween('return_date', [$start, $end]);
        }

        return $query->get();
    }


    public function getReservationById($id): ?Reservation
    {
        return Reservation::find($id);
    }


    public function updateReservation($id, array $data): Reservation
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update($data);

        return $reservation;
    }
}


