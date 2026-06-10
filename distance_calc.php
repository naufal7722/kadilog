<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Pelabuhan;

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
{
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
      cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}

$pelabuhans = Pelabuhan::all();
$results = [];

foreach ($pelabuhans as $p1) {
    list($lat1, $lon1) = array_map('trim', explode(',', $p1->koordinat));
    
    $maxDistance = 0;
    $furthestPort = null;
    
    foreach ($pelabuhans as $p2) {
        if ($p1->kode_pelabuhan === $p2->kode_pelabuhan) continue;
        
        list($lat2, $lon2) = array_map('trim', explode(',', $p2->koordinat));
        
        $distance = haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2); // Distance in KM
        $distanceNm = $distance * 0.539957; // Convert to Nautical Miles
        
        if ($distanceNm > $maxDistance) {
            $maxDistance = $distanceNm;
            $furthestPort = $p2;
        }
    }
    
    $results[] = [
        'nama' => $p1->nama_pelabuhan,
        'terjauh' => $furthestPort->nama_pelabuhan,
        'jarak_km' => round($maxDistance / 0.539957, 2),
        'jarak_nm' => round($maxDistance, 2)
    ];
}

echo json_encode($results, JSON_PRETTY_PRINT);
