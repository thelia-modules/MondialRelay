<?php

namespace MondialRelay\Model\Base;

use \Exception;
use \PDO;
use MondialRelay\Model\MondialRelayPickupAddress as ChildMondialRelayPickupAddress;
use MondialRelay\Model\MondialRelayPickupAddressQuery as ChildMondialRelayPickupAddressQuery;
use MondialRelay\Model\Map\MondialRelayPickupAddressTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the `mondial_relay_pickup_address` table.
 *
 * @method     ChildMondialRelayPickupAddressQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMondialRelayPickupAddressQuery orderByJsonRelayData($order = Criteria::ASC) Order by the json_relay_data column
 * @method     ChildMondialRelayPickupAddressQuery orderByOrderAddressId($order = Criteria::ASC) Order by the order_address_id column
 *
 * @method     ChildMondialRelayPickupAddressQuery groupById() Group by the id column
 * @method     ChildMondialRelayPickupAddressQuery groupByJsonRelayData() Group by the json_relay_data column
 * @method     ChildMondialRelayPickupAddressQuery groupByOrderAddressId() Group by the order_address_id column
 *
 * @method     ChildMondialRelayPickupAddressQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMondialRelayPickupAddressQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMondialRelayPickupAddressQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMondialRelayPickupAddressQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMondialRelayPickupAddressQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMondialRelayPickupAddressQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMondialRelayPickupAddress|null findOne(?ConnectionInterface $con = null) Return the first ChildMondialRelayPickupAddress matching the query
 * @method     ChildMondialRelayPickupAddress findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildMondialRelayPickupAddress matching the query, or a new ChildMondialRelayPickupAddress object populated from the query conditions when no match is found
 *
 * @method     ChildMondialRelayPickupAddress|null findOneById(int $id) Return the first ChildMondialRelayPickupAddress filtered by the id column
 * @method     ChildMondialRelayPickupAddress|null findOneByJsonRelayData(string $json_relay_data) Return the first ChildMondialRelayPickupAddress filtered by the json_relay_data column
 * @method     ChildMondialRelayPickupAddress|null findOneByOrderAddressId(int $order_address_id) Return the first ChildMondialRelayPickupAddress filtered by the order_address_id column
 *
 * @method     ChildMondialRelayPickupAddress requirePk($key, ?ConnectionInterface $con = null) Return the ChildMondialRelayPickupAddress by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayPickupAddress requireOne(?ConnectionInterface $con = null) Return the first ChildMondialRelayPickupAddress matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMondialRelayPickupAddress requireOneById(int $id) Return the first ChildMondialRelayPickupAddress filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayPickupAddress requireOneByJsonRelayData(string $json_relay_data) Return the first ChildMondialRelayPickupAddress filtered by the json_relay_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMondialRelayPickupAddress requireOneByOrderAddressId(int $order_address_id) Return the first ChildMondialRelayPickupAddress filtered by the order_address_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMondialRelayPickupAddress[]|Collection find(?ConnectionInterface $con = null) Return ChildMondialRelayPickupAddress objects based on current ModelCriteria
 * @psalm-method Collection&\Traversable<ChildMondialRelayPickupAddress> find(?ConnectionInterface $con = null) Return ChildMondialRelayPickupAddress objects based on current ModelCriteria
 *
 * @method     ChildMondialRelayPickupAddress[]|Collection findById(int|array<int> $id) Return ChildMondialRelayPickupAddress objects filtered by the id column
 * @psalm-method Collection&\Traversable<ChildMondialRelayPickupAddress> findById(int|array<int> $id) Return ChildMondialRelayPickupAddress objects filtered by the id column
 * @method     ChildMondialRelayPickupAddress[]|Collection findByJsonRelayData(string|array<string> $json_relay_data) Return ChildMondialRelayPickupAddress objects filtered by the json_relay_data column
 * @psalm-method Collection&\Traversable<ChildMondialRelayPickupAddress> findByJsonRelayData(string|array<string> $json_relay_data) Return ChildMondialRelayPickupAddress objects filtered by the json_relay_data column
 * @method     ChildMondialRelayPickupAddress[]|Collection findByOrderAddressId(int|array<int> $order_address_id) Return ChildMondialRelayPickupAddress objects filtered by the order_address_id column
 * @psalm-method Collection&\Traversable<ChildMondialRelayPickupAddress> findByOrderAddressId(int|array<int> $order_address_id) Return ChildMondialRelayPickupAddress objects filtered by the order_address_id column
 *
 * @method     ChildMondialRelayPickupAddress[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildMondialRelayPickupAddress> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 */
abstract class MondialRelayPickupAddressQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \MondialRelay\Model\Base\MondialRelayPickupAddressQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'TheliaMain', $modelName = '\\MondialRelay\\Model\\MondialRelayPickupAddress', ?string $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMondialRelayPickupAddressQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMondialRelayPickupAddressQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildMondialRelayPickupAddressQuery) {
            return $criteria;
        }
        $query = new ChildMondialRelayPickupAddressQuery();
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
     * @return ChildMondialRelayPickupAddress|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MondialRelayPickupAddressTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MondialRelayPickupAddressTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildMondialRelayPickupAddress A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `json_relay_data`, `order_address_id` FROM `mondial_relay_pickup_address` WHERE `id` = :p0';
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
            /** @var ChildMondialRelayPickupAddress $obj */
            $obj = new ChildMondialRelayPickupAddress();
            $obj->hydrate($row);
            MondialRelayPickupAddressTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMondialRelayPickupAddress|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the json_relay_data column
     *
     * Example usage:
     * <code>
     * $query->filterByJsonRelayData('fooValue');   // WHERE json_relay_data = 'fooValue'
     * $query->filterByJsonRelayData('%fooValue%', Criteria::LIKE); // WHERE json_relay_data LIKE '%fooValue%'
     * $query->filterByJsonRelayData(['foo', 'bar']); // WHERE json_relay_data IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $jsonRelayData The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByJsonRelayData($jsonRelayData = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($jsonRelayData)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_JSON_RELAY_DATA, $jsonRelayData, $comparison);

        return $this;
    }

    /**
     * Filter the query on the order_address_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderAddressId(1234); // WHERE order_address_id = 1234
     * $query->filterByOrderAddressId(array(12, 34)); // WHERE order_address_id IN (12, 34)
     * $query->filterByOrderAddressId(array('min' => 12)); // WHERE order_address_id > 12
     * </code>
     *
     * @param mixed $orderAddressId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByOrderAddressId($orderAddressId = null, ?string $comparison = null)
    {
        if (is_array($orderAddressId)) {
            $useMinMax = false;
            if (isset($orderAddressId['min'])) {
                $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID, $orderAddressId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderAddressId['max'])) {
                $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID, $orderAddressId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID, $orderAddressId, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param ChildMondialRelayPickupAddress $mondialRelayPickupAddress Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($mondialRelayPickupAddress = null)
    {
        if ($mondialRelayPickupAddress) {
            $this->addUsingAlias(MondialRelayPickupAddressTableMap::COL_ID, $mondialRelayPickupAddress->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mondial_relay_pickup_address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayPickupAddressTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MondialRelayPickupAddressTableMap::clearInstancePool();
            MondialRelayPickupAddressTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayPickupAddressTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MondialRelayPickupAddressTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MondialRelayPickupAddressTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MondialRelayPickupAddressTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
