<?php

namespace App\Tests;

use App\Services\GeometryService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Activité 1 : Testez la classe GeometryService
 * Cette exercice est simple et a pour but de vous familiariser avec l'écriture de tests unitaires pour des méthodes de calcul.
 * La classe GeometryService contient plusieurs méthodes qui calculent des aires et des volumes pour différentes formes géométriques.
 * Votre tâche est d'écrire des tests unitaires pour chacune de ces méthodes
 */
class GeometryServiceTest extends KernelTestCase
{
    private GeometryService $geoService;

    public function testCalculateSquareArea(): void
    {
        self::bootKernel();
        $this->geoService = static::getContainer()->get(GeometryService::class);

        $squareArea = $this->geoService->calculateSquareArea(5);
        $this->assertEquals(25, $squareArea, "La surface d'un carré de coté 5 doit être égal à 25");
    }

    // Remplissez les test restants :)

    public function testCalculateCircleArea(): void
    {

        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();

        $this->geoService = static::getContainer()->get(GeometryService::class);

        $calculatecircleArea = $this->geoService->calculateCircleArea(2);
        $this->assertEquals(12.60, round($calculatecircleArea, 2), "La surface  d'un cercle de rayon 2 doit être égal à 12.56");
    }
    public function testCalculateRectangleArea(): void
    {


        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();

        $this->geoService = static::getContainer()->get(GeometryService::class);

        $calculerAirereactangle = $this->geoService->calculateRectangleArea(4, 5);
        $this->assertEquals(20,  $calculerAirereactangle, "la surface d'un rectangle de longueur 4 et de largeur 5 doit être égal à 20");
    }
    public function testCalculateTriangleArea(): void
    {

        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();

        $this->geoService = static::getContainer()->get(GeometryService::class);

        $calculerAiretriangle = $this->geoService->calculateTriangleArea(20, 35);
        $this->assertEquals(350,  $calculerAiretriangle, "la surface d'un triangle de base 20 etde hauteur 35 doit être égal à 350");
    }




    public function testCalculateCubeVolume(): void
    {

        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();

        $this->geoService = static::getContainer()->get(GeometryService::class);
        $calculerVolumeCube = $this->geoService->calculateCubeVolume(3);
        $this->assertEquals(27,  $calculerVolumeCube, "le volume d'un cube de côté 3 doit être égal à 27");
    }
    public function testCalculateCylinderVolume(): void
    {
        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();

        $this->geoService = static::getContainer()->get(GeometryService::class);
        $calculerVolumeCylindre = $this->geoService->calculateCylinderVolume(3, 5);
        $this->assertEquals(141.37,  round($calculerVolumeCylindre, 2), "le volume d'un cylindre de rayon 3 et de hauteur 5 doit être égal à 141.37");
    }
    public function testCalculateConeVolume(): void
    {
        // sans self::bootKernel , symfony ne démarre pas

        self::bootKernel();

        $this->geoService = static::getContainer()->get(GeometryService::class);
        $calculerVolumeCone = $this->geoService->calculateConeVolume(3, 5);
        $this->assertEquals(47.12,  round($calculerVolumeCone, 2), "le volume d'un cône de rayon 3 et de hauteur 5 doit être égal à 47.12");
    }
}
