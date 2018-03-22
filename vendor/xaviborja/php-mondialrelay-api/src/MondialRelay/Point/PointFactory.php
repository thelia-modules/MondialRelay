<?php

namespace MondialRelay\Point;

use MondialRelay\BussinessHours\BussinessHoursFactory;

/**
 * Created by PhpStorm.
 * User: albertclaret
 * Date: 14/06/17
 * Time: 09:27
 */
class PointFactory
{
    protected function safeGet($response, $var)
    {
        if (isset($response->$var)) {
            return $response->$var;
        } else {
            return '';
        }
    }

    public function create($response)
    {
        $bussines_hours = (new BussinessHoursFactory())->create($response);
        return new Point(
            $response->Num,
            str_replace(",", ".", $response->Latitude),
            str_replace(",", ".", $response->Longitude),
            $response->CP,
            [
                trim($this->safeGet($response, 'LgAdr1')),
                trim($this->safeGet($response, 'LgAdr2')),
                trim($this->safeGet($response, 'LgAdr3')),
                trim($this->safeGet($response, 'LgAdr4')),
            ],
            $response->Ville,
            $response->Pays,
            [
                $this->safeGet($response, 'Localisation1'),
                $this->safeGet($response, 'Localisation2'),
            ],
            $response->TypeActivite,
            $response->Information,
            $response->Distance,
            $bussines_hours
        );

    }
}
