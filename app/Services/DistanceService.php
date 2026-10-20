<?php

namespace App\Services;


class DistanceService
{
    private $googleApiKey;
    // private $mongoUri;
    // private $dbName;
    // private $collectionName;

    public function __construct()
    {
        
        $this->googleApiKey = '';
        // $this->mongoUri = 'mongodb://localhost:27017';
        // $this->dbName = 'ViettelPost';
        // $this->collectionName = 'BuuCuc';
    }

    // Geocode địa chỉ và trả về tọa độ
    public function geocodeAddress($diaChi)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($diaChi) . '&key=' . $this->googleApiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            return $data['results'][0]['geometry']['location'];
        }
        return false;
    }

    // Tính khoảng cách dựa trên đoạn đường đi
    public function getDrivingDistance($origin, $destination)
    {
        echo "Origin: " . $origin . "<br>";
        echo "Destination: " . $destination . "<br>";
        $url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . urlencode($origin) . '&destination=' . urlencode($destination) . '&key=' . $this->googleApiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] === 'OK') {
            return $data['routes'][0]['legs'][0]['distance']['value'] / 1000;
        }
        throw new \Exception('Directions request failed: ' . $data['status']);
    }

    // // Tìm địa chỉ gần nhất
    // public function findNearestAddress($newAddress)
    // {
    //     $client = new MongoClient($this->mongoUri);
    //     $collection = $client->selectDatabase($this->dbName)->selectCollection($this->collectionName);

    //     $newLocation = $this->geocodeAddress($newAddress);
    //     $addresses = $collection->find([]);

    //     $nearestAddress = null;
    //     $shortestDistance = PHP_INT_MAX;

    //     foreach ($addresses as $address) {
    //         try {
    //             $distance = $this->getDrivingDistance($newAddress, $address['diaChi']);
    //             if ($distance < $shortestDistance) {
    //                 $shortestDistance = $distance;
    //                 $nearestAddress = $address;
    //             }
    //         } catch (\Exception $e) {
    //             // Có thể log lỗi hoặc xử lý khác
    //         }
    //     }

    //     return ['nearestAddress' => $nearestAddress, 'shortestDistance' => $shortestDistance];
    // }

    // Tính phí ship
    public function calculateShippingCost($distance)
    {
        // Đảm bảo rằng $distance là số
        if (!is_numeric($distance)) {
            throw new \InvalidArgumentException("Distance must be a numeric value.");
        }
        if ($distance <= 2) {
            return 0;
        } elseif ($distance <= 10) {
            return 10000;
        } elseif ($distance <= 20) {
            return 15000;
        } else {
            return 15000 + ceil(($distance - 20) / 5) * 5000;
        }
    }
}
