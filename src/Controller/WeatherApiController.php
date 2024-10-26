<?php

namespace App\Controller;

use App\Entity\Forecast;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(
        WeatherUtil $weatherUtil,
        #[MapQueryParameter('name')] string $name,
        #[MapQueryParameter('countryCode')] string $countryCode,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response {
        $forecasts = $weatherUtil->getWeatherForCountryAndCity($countryCode, $name);

        if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather/index.csv.twig', [
                    'name' => $name,
                    'countryCode' => $countryCode,
                    'forecasts' => $forecasts,
                ]);
            }

            $csvData = "city,country,date,celsius\n";
            foreach ($forecasts as $forecast) {
                $csvData .= sprintf(
                    "%s,%s,%s,%s,%s\n",
                    $name,
                    $countryCode,
                    $forecast->getDate()->format('Y-m-d'),
                    $forecast->getCelsius(),
                    $forecast->getFahrenheit(),
                );
            }

            return new Response($csvData, 200, []);
        }

        if ($twig) {
            return $this->render('weather/index.json.twig', [
                'name' => $name,
                'countryCode' => $countryCode,
                'forecasts' => $forecasts,
            ]);
        }

        return $this->json([
            'name' => $name,
            'countryCode' => $countryCode,
            'forecasts' => array_map(fn(Forecast $f) => [
                'date' => $f->getDate()->format('Y-m-d'),
                'celsius' => $f->getCelsius(),
                'fahrenheit' => $f->getFahrenheit(),
            ], $forecasts),
        ]);
    }
}
