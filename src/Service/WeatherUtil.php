<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Forecast;
use App\Repository\ForecastRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherUtil extends AbstractController
{
    private ForecastRepository $forecastRepository;
    private LocationRepository $locationRepository;

    public function __construct(
        ForecastRepository $forecastRepository,
        LocationRepository $locationRepository,
    ) {
        $this->forecastRepository = $forecastRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        $forecasts = $this->forecastRepository->findByLocation($location);

        return $forecasts;
    }

    /**
     * @return Forecast[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findByCountryCodeAndName($countryCode, $city);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }

        $forecasts = $this->forecastRepository->findByLocation($location);

        return $forecasts;
    }
}
