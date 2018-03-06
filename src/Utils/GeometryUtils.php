<?php


namespace Jackal\ImageMerge\Utils;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\ValueObject\Coordinate;

class GeometryUtils
{
    public static function getClockwiseOrder(MultiCoordinateCommandOption $multiCoordinateCommandOption){

        $Xs = [];
        $Ys = [];
        $points = $multiCoordinateCommandOption->getCoordinates();
        $coords = [];

        foreach ($points as $k => $coordinateCommandOption) {

            if ($k == 0) {
                $Xs[] = $coordinateCommandOption;
                $coords[] = new Coordinate($coordinateCommandOption,$points[$k+1]);
            } else {
                if (($k % 2) == 1) {
                    $Ys[] = $coordinateCommandOption;
                }
                if (($k % 2) == 0) {
                    $coords[] = new Coordinate($coordinateCommandOption,$points[$k+1]);
                    $Xs[] = $coordinateCommandOption;
                }
            }
        }


        $minX = min($Xs);
        $minY = min($Ys);

        $maxX = max($Xs);
        $maxY = max($Ys);

        $centerX = ($maxX - $minX) / 2;
        $centerY = ($maxY - $minY) / 2;

        $outCoords = [];

        /** @var Coordinate $coord */
        foreach ($coords as $coord){
            //top-left
            if($coord->getX() <= $centerX and $coord->getY() <= $centerY){
                $outCoords[0] = $coord;
            }
            //top-right
            if($coord->getX() >= $centerX and $coord->getY() <= $centerY){
                $outCoords[1] = $coord;
            }
            //bottom-right
            if($coord->getX() >= $centerX and $coord->getY() >= $centerY){
                $outCoords[2] = $coord;
            }
            //bottom-left
            if($coord->getX() <= $centerX and $coord->getY() >= $centerY){
                $outCoords[3] = $coord;
            }
        }

        return new MultiCoordinateCommandOption($outCoords);


    }
}