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
        $criteria = $request->all();
        $cars = $this->carService->searchCars($criteria);

        if ($cars->isEmpty()) {
            return response()->json(['message' => 'No cars with this search'], ResponseAlias::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $cars], ResponseAlias::HTTP_OK);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        $imageName = $request->file('image')->getClientOriginalName();
        $documentName = $request->file('document')->getClientOriginalName();
        $imagePath = "storage/" . $request->file('image')->store('car-images');
        $documentPath = "storage/" . $request->file('document')->store('car-documents');

        $carData = $request->validated();
        $carData['image_name'] = $imageName;
        $carData['document_name'] = $documentName;

        $carData['image'] = $imagePath;
        $carData['document'] = $documentPath;

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
    public function update(UpdateCarRequest $request, $carId)
    {
        $carData = $request->validated();
        $car = $this->carService->update($carData, $carId);

        if (!$car) {
            return response()->json(['message' => 'Failed to update car'], 500);
        }

        return CarResource::make($car);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $carId)
    {
        $deleted = $this->carService->destroy($carId);

        if ($deleted) {
            return response(['message' => 'Car deleted'], ResponseAlias::HTTP_OK);
        } else {
            return response(['message' => 'Failed to delete car'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
