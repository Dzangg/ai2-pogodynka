<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ForecastRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{countryCode}/{name}', name: 'app_weather')]
    public function city(
        LocationRepository $locationRepository,
        ForecastRepository $forecastRepository,
        string $countryCode,
        string $name,
    ): Response
    {
        $location = $locationRepository->findByCountryCodeAndName($countryCode, $name);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }

        $forecasts = $forecastRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'forecasts' => $forecasts,
        ]);
    }
}
