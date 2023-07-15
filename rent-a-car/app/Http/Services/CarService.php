<?php

namespace app\Http\Services;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Car;

class  CarService
{
    public function store($carData)
    {
        return Car::query()->create($carData);
    }

    public function update($carData, $carId)
    {
        $car = Car::find($carId);
        if (!$car) {
            return false;
        }
        $car->update($carData);
        return $car;
    }

    public function destroy(int $carId): bool
    {
        $car = Car::find($carId);

        return $car->delete();
    }


    public function searchCars(array $criteria)
    {
        $query = Car::query();

        if (isset($criteria['brand'])) {
            $query->where('brand', 'like', '%' . $criteria['brand'] . '%');
        }

        if (isset($criteria['model'])) {
            $query->where('model', 'like', '%' . $criteria['model'] . '%');
        }

        if (isset($criteria['year'])) {
            $query->where('year', $criteria['year']);
        }

        if (isset($criteria['min_price'])) {
            $query->where('daily_price', '>=', $criteria['min_price']);
        }

        if (isset($criteria['max_price'])) {
            $query->where('daily_price', '<=', $criteria['max_price']);
        }

        return $query->get();
    }
}


