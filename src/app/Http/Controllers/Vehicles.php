<?php

namespace App\Http\Controllers;

use App\VehicleApi;
use Illuminate\Http\Request;

class Vehicles extends Controller
{
    private $vehicleApi;
    public function __construct(VehicleApi $vehicleApi)
    {
        $this->vehicleApi = $vehicleApi;
    }

    public function index($yearModel, $manufacturer, $model)
    {
        $vehicles = $this->vehicleApi->getVehiclesFromApi($yearModel, $manufacturer, $model);

        $response = [
            'Count' => $vehicles->count(),
            'Results' => $vehicles
        ];
        return response()->json($response);
    }
}
