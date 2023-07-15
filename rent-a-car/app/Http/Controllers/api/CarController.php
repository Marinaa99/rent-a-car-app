<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Http\Services\CarService;
use App\Models\Car;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;



class CarController extends Controller
{
    private $carService;

    public function  __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $allCars = $this->carService->getAllCars();

        return response(['data' => $allCars], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        $carData = $request->validated();
        $car = $this->carService->store($carData);
        return CarResource::make($car);
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return CarResource::make($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, int $carId)
    {
        $carData = $request->validated();
        $car = $this->carService->update($carId, $carData);

        return CarResource::make($car);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $carId)
    {
        $deleted = $this->carService->destroy($carId);

        if ($deleted) {
            return response()->json(['message' => 'Car deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete car'], 500);
        }
    }
}
