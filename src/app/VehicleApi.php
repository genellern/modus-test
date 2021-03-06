<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class VehicleApi extends Model
{
    public function getVehiclesFromApi($yearModel, $manufacturer, $model) :Collection
    {
        $fields = collect(['Description', 'VehicleId']);
        $httpClient = new Client();
        $path = sprintf(env('NHTSA_MODEL_REQUEST_PATTERN'), $yearModel, $manufacturer, $model);

        $response = $httpClient->get(
            env('NHTSA_HOST') . env('NHTSA_ENDPOINT') . $path,
            ['query' => ['format' => 'json']]
        );
        $records = json_decode($response->getBody()->getContents(), true);
        return $this->organizeVehiclesCollection($records['Results'], $fields);
    }

    private function organizeVehiclesCollection($records, $fields)
    {
        $filteredRecords = collect([]);

        collect($records)->each(function ($item, $key) use ($fields, $filteredRecords) {
            $filteredRecords->push($fields->combine(array_values($item)));
        });
        return $filteredRecords;
    }

    public function getVehiclesCrashRating(Collection $vehicles) :Collection
    {
        $httpClient = new Client();
        $vehicles->each(function (&$item) use ($httpClient) {

            $path = sprintf(env('NHTSA_RATING_REQUEST_PATTERN'), $item['VehicleId']);
            $response = $httpClient->get(
                env('NHTSA_HOST') . env('NHTSA_ENDPOINT') . $path,
                ['query' => ['format' => 'json']]
            );
            $rating = json_decode($response->getBody()->getContents(), true);
            $item->put('CrashRating' , $rating['Results'][0]['OverallRating']);
        });
        return $vehicles;
    }
}
