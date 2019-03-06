<?php

namespace App\Http\Controllers;

use App\VehicleApi;
use Illuminate\Http\Request;

class Vehicles extends Controller
{
    private $vehicleApi;
    private $request;
    public function __construct(VehicleApi $vehicleApi, Request $request)
    {
        $this->vehicleApi = $vehicleApi;
        $this->request = $request;
    }

    public function index($modelYear = '', $manufacturer = '', $model = '')
    {
        $response = ['Count' => 0, 'Results' => []];

        if ($this->request->isMethod('post') && $this->request->has(['modelYear', 'manufacturer', 'model'])) {

            extract($this->request->json()->all());
        }

        if (!empty($modelYear) && !empty($manufacturer) && !empty($model)) {

            $vehicles = $this->vehicleApi->getVehiclesFromApi($modelYear, $manufacturer, $model);

            $response = [
                'Count' => $vehicles->count(),
                'Results' => $vehicles
            ];
        }
        return response()->json($response);
    }
}
