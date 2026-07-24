<?php

namespace MondialRelay\Model\Base;

use \Exception;
use \PDO;
use MondialRelay\Model\MondialRelayDeliveryInsurance as ChildMondialRelayDeliveryInsurance;
use MondialRelay\Model\MondialRelayDeliveryInsuranceQuery as ChildMondialRelayDeliveryInsuranceQuery;
use MondialRelay\Model\Map\MondialRelayDeliveryInsuranceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `mondial_relay_delivery_insurance` table.
 *
 * @method     ChildMondialRelayDeliveryInsuranceQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMondialRelayDeliveryInsuranceQuery orderByLevel($order = Criteria::ASC) Order by the level column
 * @method     ChildMondialRelayDeliveryInsuranceQuery orderByMaxValue($order = Criteria::ASC) Order by the max_value column
 * @method     ChildMondialRelayDeliveryInsuranceQuery orderByPriceWithTax($order = Criteria::ASC) Order by the price_with_tax column
 *
 * @method     ChildMondialRelayDeliveryInsuranceQuery groupById() Group by the id column
 * @method     ChildMondialRelayDeliveryInsuranceQuery groupByLevel() Group by the level column
 * @method     ChildMondialRelayDeliveryInsuranceQuery groupByMaxValue() Group by the max_value column
 * @method     ChildMondialRelayDeliveryInsuranceQuery groupByPriceWithTax() Group by the price_with_tax column
 *
 * @method     ChildMondialRelayDeliveryInsuranceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMondialRelayDeliveryInsuranceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMondialRelayDeliveryInsuranceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMondialRelayDeliveryInsuranceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMondialRelayDeliveryInsuranceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMondialRelayDeliveryInsuranceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMondialRelayDeliveryInsurance|null findOne(?ConnectionInterface $con = null) Return the first ChildMondialRelayDeliveryInsurance matching the query
 * @method     ChildMondialRelayDeliveryInsurance findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildMondialRelayDeliveryInsurance matching the query, or a new ChildMondialRelayDeliveryInsurance object populated from the query conditions when no match is found
 *
 * @method     ChildMondialRelayDeliveryInsurance|null findOneById(int $id) Return the first ChildMondialRelayDeliveryInsurance filtered by the id column
 * @method     ChildMondialRelayDeliveryInsurance|null findOneByLevel(int $level) Return the first ChildMondialRelayDeliveryInsurance filtered by the level column
 * @method     ChildMondialRelayDeliveryInsurance|null findOneByMaxValue(string $max_value) Return the first ChildMondialRelayDeliveryInsurance filtered by the max_value column
 * @method     ChildMondialRelayDeliveryInsurance|null findOneByPriceWithTax(string $price_with_tax) Return the first ChildMondialRelayDeliveryInsurance filtered by the price_with_tax column
 *
 * @method     ChildMondialRelayDeliveryInsurance requirePk($key, ?ConnectionInterface $con = null) Return the ChildMondialRelayDeliveryInsurance by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayDeliveryInsurance requireOne(?ConnectionInterface $con = null) Return the first ChildMondialRelayDeliveryInsurance matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMondialRelayDeliveryInsurance requireOneById(int $id) Return the first ChildMondialRelayDeliveryInsurance filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayDeliveryInsurance requireOneByLevel(int $level) Return the first ChildMondialRelayDeliveryInsurance filtered by the level column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayDeliveryInsurance requireOneByMaxValue(string $max_value) Return the first ChildMondialRelayDeliveryInsurance filtered by the max_value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayDeliveryInsurance requireOneByPriceWithTax(string $price_with_tax) Return the first ChildMondialRelayDeliveryInsurance filtered by the price_with_tax column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMondialRelayDeliveryInsurance[]|Collection find(?ConnectionInterface $con = null) Return ChildMondialRelayDeliveryInsurance objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildMondialRelayDeliveryInsurance> find(?ConnectionInterface $con = null) Return ChildMondialRelayDeliveryInsurance objects based on current ModelCriteria
 *
 * @method     ChildMondialRelayDeliveryInsurance[]|Collection findById(int|array<int> $id) Return ChildMondialRelayDeliveryInsurance objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildMondialRelayDeliveryInsurance> findById(int|array<int> $id) Return ChildMondialRelayDeliveryInsurance objects filtered by the id column
 * @method     ChildMondialRelayDeliveryInsurance[]|Collection findByLevel(int|array<int> $level) Return ChildMondialRelayDeliveryInsurance objects filtered by the level column
 * @psalm-method Collection&\Traversable<ChildMondialRelayDeliveryInsurance> findByLevel(int|array<int> $level) Return ChildMondialRelayDeliveryInsurance objects filtered by the level column
 * @method     ChildMondialRelayDeliveryInsurance[]|Collection findByMaxValue(string|array<string> $max_value) Return ChildMondialRelayDeliveryInsurance objects filtered by the max_value column
 * @psalm-method Collection&\Traversable<ChildMondialRelayDeliveryInsurance> findByMaxValue(string|array<string> $max_value) Return ChildMondialRelayDeliveryInsurance objects filtered by the max_value column
 * @method     ChildMondialRelayDeliveryInsurance[]|Collection findByPriceWithTax(string|array<string> $price_with_tax) Return ChildMondialRelayDeliveryInsurance objects filtered by the price_with_tax column
 * @psalm-method Collection&\Traversable<ChildMondialRelayDeliveryInsurance> findByPriceWithTax(string|array<string> $price_with_tax) Return ChildMondialRelayDeliveryInsurance objects filtered by the price_with_tax column
 *
 * @method     ChildMondialRelayDeliveryInsurance[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildMondialRelayDeliveryInsurance> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class MondialRelayDeliveryInsuranceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MondialRelay\Model\Base\MondialRelayDeliveryInsuranceQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'TheliaMain', $modelName = '\\MondialRelay\\Model\\MondialRelayDeliveryInsurance', ?string $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMondialRelayDeliveryInsuranceQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildMondialRelayDeliveryInsuranceQuery) {
            return $criteria;
        }
        $query = new ChildMondialRelayDeliveryInsuranceQuery();
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
     * @return ChildMondialRelayDeliveryInsurance|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MondialRelayDeliveryInsuranceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMondialRelayDeliveryInsurance A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `level`, `max_value`, `price_with_tax` FROM `mondial_relay_delivery_insurance` WHERE `id` = :p0';
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
            /** @var ChildMondialRelayDeliveryInsurance $obj */
            $obj = new ChildMondialRelayDeliveryInsurance();
            $obj->hydrate($row);
            MondialRelayDeliveryInsuranceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMondialRelayDeliveryInsurance|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the level column
     *
     * Example usage:
     * <code>
     * $query->filterByLevel(1234); // WHERE level = 1234
     * $query->filterByLevel(array(12, 34)); // WHERE level IN (12, 34)
     * $query->filterByLevel(array('min' => 12)); // WHERE level > 12
     * </code>
     *
     * @param mixed $level The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByLevel($level = null, ?string $comparison = null)
    {
        if (is_array($level)) {
            $useMinMax = false;
            if (isset($level['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_LEVEL, $level['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($level['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_LEVEL, $level['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_LEVEL, $level, $comparison);

        return $this;
    }

    /**
     * Filter the query on the max_value column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxValue(1234); // WHERE max_value = 1234
     * $query->filterByMaxValue(array(12, 34)); // WHERE max_value IN (12, 34)
     * $query->filterByMaxValue(array('min' => 12)); // WHERE max_value > 12
     * </code>
     *
     * @param mixed $maxValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByMaxValue($maxValue = null, ?string $comparison = null)
    {
        if (is_array($maxValue)) {
            $useMinMax = false;
            if (isset($maxValue['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE, $maxValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxValue['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE, $maxValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE, $maxValue, $comparison);

        return $this;
    }

    /**
     * Filter the query on the price_with_tax column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceWithTax(1234); // WHERE price_with_tax = 1234
     * $query->filterByPriceWithTax(array(12, 34)); // WHERE price_with_tax IN (12, 34)
     * $query->filterByPriceWithTax(array('min' => 12)); // WHERE price_with_tax > 12
     * </code>
     *
     * @param mixed $priceWithTax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPriceWithTax($priceWithTax = null, ?string $comparison = null)
    {
        if (is_array($priceWithTax)) {
            $useMinMax = false;
            if (isset($priceWithTax['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX, $priceWithTax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceWithTax['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX, $priceWithTax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX, $priceWithTax, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildMondialRelayDeliveryInsurance $mondialRelayDeliveryInsurance Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($mondialRelayDeliveryInsurance = null)
    {
        if ($mondialRelayDeliveryInsurance) {
            $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::COL_ID, $mondialRelayDeliveryInsurance->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mondial_relay_delivery_insurance table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MondialRelayDeliveryInsuranceTableMap::clearInstancePool();
            MondialRelayDeliveryInsuranceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MondialRelayDeliveryInsuranceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MondialRelayDeliveryInsuranceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
