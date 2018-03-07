<?php


namespace Jackal\ImageMerge\Utils;

use Jackal\ImageMerge\Command\Options\MultiCoordinateCommandOption;
use Jackal\ImageMerge\ValueObject\Coordinate;
use Jackal\ImageMerge\ValueObject\Dimention;

class GeometryUtils
{
    public static function getClockwiseOrder(MultiCoordinateCommandOption $multiCoordinateCommandOption){

        $coords = $multiCoordinateCommandOption->getCoordinates();


        $centerX = ($multiCoordinateCommandOption->getMaxX() - $multiCoordinateCommandOption->getMinX()) / 2;
        $centerY = ($multiCoordinateCommandOption->getMaxY() - $multiCoordinateCommandOption->getMinY()) / 2;

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