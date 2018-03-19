<?php
/*************************************************************************************/
/*                                                                                   */
/*      This file is not free software                                               */
/*                                                                                   */
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 28/04/2016 14:41
 */
namespace MondialRelay\Event;

use Thelia\Core\Event\ActionEvent;

class FindRelayEvent extends ActionEvent
{
    /** @var int */
    protected $countryId;

    /** @var string */
    protected $city;

    /** @var string */
    protected $zipcode;

    /** @var float */
    protected $searchRadius;

    /** @var array */
    protected $points;

    /** @var string */
    protected $numPointRelais = '';

    /**
     * FindRelayEvent constructor.
     * @param int $countryId
     * @param string $city
     * @param string $zipcode
     * @param float $searchRadius
     */
    public function __construct($countryId, $city, $zipcode, $searchRadius)
    {
        $this->countryId = $countryId;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->searchRadius = $searchRadius;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @return float
     */
    public function getSearchRadius()
    {
        return $this->searchRadius;
    }

    /**
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param array $points
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumPointRelais()
    {
        return $this->numPointRelais;
    }

    /**
     * @param string $numPointRelais
     * @return $this
     */
    public function setNumPointRelais($numPointRelais)
    {
        $this->numPointRelais = $numPointRelais;
        return $this;
    }
}
