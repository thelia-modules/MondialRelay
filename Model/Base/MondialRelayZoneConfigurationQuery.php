<?php

namespace MondialRelay\Model\Base;

use \Exception;
use \PDO;
use MondialRelay\Model\MondialRelayZoneConfiguration as ChildMondialRelayZoneConfiguration;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery as ChildMondialRelayZoneConfigurationQuery;
use MondialRelay\Model\Map\MondialRelayZoneConfigurationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Area;

/**
 * Base class that represents a query for the `mondial_relay_zone_configuration` table.
 *
 * @method     ChildMondialRelayZoneConfigurationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMondialRelayZoneConfigurationQuery orderByDeliveryTime($order = Criteria::ASC) Order by the delivery_time column
 * @method     ChildMondialRelayZoneConfigurationQuery orderByDeliveryType($order = Criteria::ASC) Order by the delivery_type column
 * @method     ChildMondialRelayZoneConfigurationQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 *
 * @method     ChildMondialRelayZoneConfigurationQuery groupById() Group by the id column
 * @method     ChildMondialRelayZoneConfigurationQuery groupByDeliveryTime() Group by the delivery_time column
 * @method     ChildMondialRelayZoneConfigurationQuery groupByDeliveryType() Group by the delivery_type column
 * @method     ChildMondialRelayZoneConfigurationQuery groupByAreaId() Group by the area_id column
 *
 * @method     ChildMondialRelayZoneConfigurationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMondialRelayZoneConfigurationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMondialRelayZoneConfigurationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMondialRelayZoneConfigurationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMondialRelayZoneConfigurationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMondialRelayZoneConfigurationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMondialRelayZoneConfigurationQuery leftJoinArea($relationAlias = null) Adds a LEFT JOIN clause to the query using the Area relation
 * @method     ChildMondialRelayZoneConfigurationQuery rightJoinArea($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Area relation
 * @method     ChildMondialRelayZoneConfigurationQuery innerJoinArea($relationAlias = null) Adds a INNER JOIN clause to the query using the Area relation
 *
 * @method     ChildMondialRelayZoneConfigurationQuery joinWithArea($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Area relation
 *
 * @method     ChildMondialRelayZoneConfigurationQuery leftJoinWithArea() Adds a LEFT JOIN clause and with to the query using the Area relation
 * @method     ChildMondialRelayZoneConfigurationQuery rightJoinWithArea() Adds a RIGHT JOIN clause and with to the query using the Area relation
 * @method     ChildMondialRelayZoneConfigurationQuery innerJoinWithArea() Adds a INNER JOIN clause and with to the query using the Area relation
 *
 * @method     \Thelia\Model\AreaQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMondialRelayZoneConfiguration|null findOne(?ConnectionInterface $con = null) Return the first ChildMondialRelayZoneConfiguration matching the query
 * @method     ChildMondialRelayZoneConfiguration findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildMondialRelayZoneConfiguration matching the query, or a new ChildMondialRelayZoneConfiguration object populated from the query conditions when no match is found
 *
 * @method     ChildMondialRelayZoneConfiguration|null findOneById(int $id) Return the first ChildMondialRelayZoneConfiguration filtered by the id column
 * @method     ChildMondialRelayZoneConfiguration|null findOneByDeliveryTime(int $delivery_time) Return the first ChildMondialRelayZoneConfiguration filtered by the delivery_time column
 * @method     ChildMondialRelayZoneConfiguration|null findOneByDeliveryType(int $delivery_type) Return the first ChildMondialRelayZoneConfiguration filtered by the delivery_type column
 * @method     ChildMondialRelayZoneConfiguration|null findOneByAreaId(int $area_id) Return the first ChildMondialRelayZoneConfiguration filtered by the area_id column
 *
 * @method     ChildMondialRelayZoneConfiguration requirePk($key, ?ConnectionInterface $con = null) Return the ChildMondialRelayZoneConfiguration by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayZoneConfiguration requireOne(?ConnectionInterface $con = null) Return the first ChildMondialRelayZoneConfiguration matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMondialRelayZoneConfiguration requireOneById(int $id) Return the first ChildMondialRelayZoneConfiguration filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayZoneConfiguration requireOneByDeliveryTime(int $delivery_time) Return the first ChildMondialRelayZoneConfiguration filtered by the delivery_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayZoneConfiguration requireOneByDeliveryType(int $delivery_type) Return the first ChildMondialRelayZoneConfiguration filtered by the delivery_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayZoneConfiguration requireOneByAreaId(int $area_id) Return the first ChildMondialRelayZoneConfiguration filtered by the area_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMondialRelayZoneConfiguration[]|Collection find(?ConnectionInterface $con = null) Return ChildMondialRelayZoneConfiguration objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildMondialRelayZoneConfiguration> find(?ConnectionInterface $con = null) Return ChildMondialRelayZoneConfiguration objects based on current ModelCriteria
 *
 * @method     ChildMondialRelayZoneConfiguration[]|Collection findById(int|array<int> $id) Return ChildMondialRelayZoneConfiguration objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildMondialRelayZoneConfiguration> findById(int|array<int> $id) Return ChildMondialRelayZoneConfiguration objects filtered by the id column
 * @method     ChildMondialRelayZoneConfiguration[]|Collection findByDeliveryTime(int|array<int> $delivery_time) Return ChildMondialRelayZoneConfiguration objects filtered by the delivery_time column
 * @psalm-method Collection&\Traversable<ChildMondialRelayZoneConfiguration> findByDeliveryTime(int|array<int> $delivery_time) Return ChildMondialRelayZoneConfiguration objects filtered by the delivery_time column
 * @method     ChildMondialRelayZoneConfiguration[]|Collection findByDeliveryType(int|array<int> $delivery_type) Return ChildMondialRelayZoneConfiguration objects filtered by the delivery_type column
 * @psalm-method Collection&\Traversable<ChildMondialRelayZoneConfiguration> findByDeliveryType(int|array<int> $delivery_type) Return ChildMondialRelayZoneConfiguration objects filtered by the delivery_type column
 * @method     ChildMondialRelayZoneConfiguration[]|Collection findByAreaId(int|array<int> $area_id) Return ChildMondialRelayZoneConfiguration objects filtered by the area_id column
 * @psalm-method Collection&\Traversable<ChildMondialRelayZoneConfiguration> findByAreaId(int|array<int> $area_id) Return ChildMondialRelayZoneConfiguration objects filtered by the area_id column
 *
 * @method     ChildMondialRelayZoneConfiguration[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildMondialRelayZoneConfiguration> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class MondialRelayZoneConfigurationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MondialRelay\Model\Base\MondialRelayZoneConfigurationQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'TheliaMain', $modelName = '\\MondialRelay\\Model\\MondialRelayZoneConfiguration', ?string $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMondialRelayZoneConfigurationQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMondialRelayZoneConfigurationQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildMondialRelayZoneConfigurationQuery) {
            return $criteria;
        }
        $query = new ChildMondialRelayZoneConfigurationQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMondialRelayZoneConfiguration|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MondialRelayZoneConfigurationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MondialRelayZoneConfigurationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMondialRelayZoneConfiguration A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `delivery_time`, `delivery_type`, `area_id` FROM `mondial_relay_zone_configuration` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMondialRelayZoneConfiguration $obj */
            $obj = new ChildMondialRelayZoneConfiguration();
            $obj->hydrate($row);
            MondialRelayZoneConfigurationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildMondialRelayZoneConfiguration|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return Collection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the delivery_time column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryTime(1234); // WHERE delivery_time = 1234
     * $query->filterByDeliveryTime(array(12, 34)); // WHERE delivery_time IN (12, 34)
     * $query->filterByDeliveryTime(array('min' => 12)); // WHERE delivery_time > 12
     * </code>
     *
     * @param mixed $deliveryTime The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDeliveryTime($deliveryTime = null, ?string $comparison = null)
    {
        if (is_array($deliveryTime)) {
            $useMinMax = false;
            if (isset($deliveryTime['min'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_DELIVERY_TIME, $deliveryTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryTime['max'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_DELIVERY_TIME, $deliveryTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_DELIVERY_TIME, $deliveryTime, $comparison);

        return $this;
    }

    /**
     * Filter the query on the delivery_type column
     *
     * Example usage:
     * <code>
     * $query->filterByDeliveryType(1234); // WHERE delivery_type = 1234
     * $query->filterByDeliveryType(array(12, 34)); // WHERE delivery_type IN (12, 34)
     * $query->filterByDeliveryType(array('min' => 12)); // WHERE delivery_type > 12
     * </code>
     *
     * @param mixed $deliveryType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByDeliveryType($deliveryType = null, ?string $comparison = null)
    {
        if (is_array($deliveryType)) {
            $useMinMax = false;
            if (isset($deliveryType['min'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_DELIVERY_TYPE, $deliveryType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deliveryType['max'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_DELIVERY_TYPE, $deliveryType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_DELIVERY_TYPE, $deliveryType, $comparison);

        return $this;
    }

    /**
     * Filter the query on the area_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAreaId(1234); // WHERE area_id = 1234
     * $query->filterByAreaId(array(12, 34)); // WHERE area_id IN (12, 34)
     * $query->filterByAreaId(array('min' => 12)); // WHERE area_id > 12
     * </code>
     *
     * @see       filterByArea()
     *
     * @param mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, ?string $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_AREA_ID, $areaId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Thelia\Model\Area object
     *
     * @param \Thelia\Model\Area|ObjectCollection $area The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByArea($area, ?string $comparison = null)
    {
        if ($area instanceof \Thelia\Model\Area) {
            return $this
                ->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_AREA_ID, $area->getId(), $comparison);
        } elseif ($area instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_AREA_ID, $area->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByArea() only accepts arguments of type \Thelia\Model\Area or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Area relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinArea(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Area');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Area');
        }

        return $this;
    }

    /**
     * Use the Area relation Area object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Thelia\Model\AreaQuery A secondary query class using the current class as primary query
     */
    public function useAreaQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArea($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Area', '\Thelia\Model\AreaQuery');
    }

    /**
     * Use the Area relation Area object
     *
     * @param callable(\Thelia\Model\AreaQuery):\Thelia\Model\AreaQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withAreaQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useAreaQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Area table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \Thelia\Model\AreaQuery The inner query object of the EXISTS statement
     */
    public function useAreaExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var $q \Thelia\Model\AreaQuery */
        $q = $this->useExistsQuery('Area', $modelAlias, $queryClass, $typeOfExists);
        return $q;
    }

    /**
     * Use the relation to Area table for a NOT EXISTS query.
     *
     * @see useAreaExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Thelia\Model\AreaQuery The inner query object of the NOT EXISTS statement
     */
    public function useAreaNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var $q \Thelia\Model\AreaQuery */
        $q = $this->useExistsQuery('Area', $modelAlias, $queryClass, 'NOT EXISTS');
        return $q;
    }

    /**
     * Use the relation to Area table for an IN query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the IN query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \Thelia\Model\AreaQuery The inner query object of the IN statement
     */
    public function useInAreaQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = 'IN')
    {
        /** @var $q \Thelia\Model\AreaQuery */
        $q = $this->useInQuery('Area', $modelAlias, $queryClass, $typeOfIn);
        return $q;
    }

    /**
     * Use the relation to Area table for a NOT IN query.
     *
     * @see useAreaInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the NOT IN query, like ExtendedBookQuery::class
     *
     * @return \Thelia\Model\AreaQuery The inner query object of the NOT IN statement
     */
    public function useNotInAreaQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var $q \Thelia\Model\AreaQuery */
        $q = $this->useInQuery('Area', $modelAlias, $queryClass, 'NOT IN');
        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param ChildMondialRelayZoneConfiguration $mondialRelayZoneConfiguration Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($mondialRelayZoneConfiguration = null)
    {
        if ($mondialRelayZoneConfiguration) {
            $this->addUsingAlias(MondialRelayZoneConfigurationTableMap::COL_ID, $mondialRelayZoneConfiguration->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mondial_relay_zone_configuration table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayZoneConfigurationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MondialRelayZoneConfigurationTableMap::clearInstancePool();
            MondialRelayZoneConfigurationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayZoneConfigurationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MondialRelayZoneConfigurationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MondialRelayZoneConfigurationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MondialRelayZoneConfigurationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
