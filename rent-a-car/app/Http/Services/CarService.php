<?php

namespace app\Http\Services;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Car;

class  CarService
{
    public function store(array $data): Car
    {
        $car = Car::create([
            'brand' => $data['brand'],
            'model' => $data['model'],
            'year' => $data['year'],
            'daily_price' => $data['daily_price'],

        ]);
        return $car;
    }


    public function update(int $carId, array $data): Car
    {
        $car = Car::findOrFail($carId);

        $car->update([
            'brand' => $data['brand'],
            'model' => $data['model'],
            'year' => $data['year'],
            'daily_price' => $data['daily_price'],
        ]);

        return $car;
    }

    public function destroy(int $carId): bool
    {
        $car = Car::find($carId);

        return $car->delete();
    }


    public function getAllCars()
    {
        return Car::all();
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


