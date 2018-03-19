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
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mondial_relay_delivery_insurance' table.
 *
 *
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
 * @method     ChildMondialRelayDeliveryInsurance findOne(ConnectionInterface $con = null) Return the first ChildMondialRelayDeliveryInsurance matching the query
 * @method     ChildMondialRelayDeliveryInsurance findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMondialRelayDeliveryInsurance matching the query, or a new ChildMondialRelayDeliveryInsurance object populated from the query conditions when no match is found
 *
 * @method     ChildMondialRelayDeliveryInsurance findOneById(int $id) Return the first ChildMondialRelayDeliveryInsurance filtered by the id column
 * @method     ChildMondialRelayDeliveryInsurance findOneByLevel(int $level) Return the first ChildMondialRelayDeliveryInsurance filtered by the level column
 * @method     ChildMondialRelayDeliveryInsurance findOneByMaxValue(string $max_value) Return the first ChildMondialRelayDeliveryInsurance filtered by the max_value column
 * @method     ChildMondialRelayDeliveryInsurance findOneByPriceWithTax(string $price_with_tax) Return the first ChildMondialRelayDeliveryInsurance filtered by the price_with_tax column
 *
 * @method     array findById(int $id) Return ChildMondialRelayDeliveryInsurance objects filtered by the id column
 * @method     array findByLevel(int $level) Return ChildMondialRelayDeliveryInsurance objects filtered by the level column
 * @method     array findByMaxValue(string $max_value) Return ChildMondialRelayDeliveryInsurance objects filtered by the max_value column
 * @method     array findByPriceWithTax(string $price_with_tax) Return ChildMondialRelayDeliveryInsurance objects filtered by the price_with_tax column
 *
 */
abstract class MondialRelayDeliveryInsuranceQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \MondialRelay\Model\Base\MondialRelayDeliveryInsuranceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\MondialRelay\\Model\\MondialRelayDeliveryInsurance', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMondialRelayDeliveryInsuranceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MondialRelay\Model\MondialRelayDeliveryInsuranceQuery) {
            return $criteria;
        }
        $query = new \MondialRelay\Model\MondialRelayDeliveryInsuranceQuery();
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
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MondialRelayDeliveryInsuranceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildMondialRelayDeliveryInsurance A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LEVEL, MAX_VALUE, PRICE_WITH_TAX FROM mondial_relay_delivery_insurance WHERE ID = :p0';
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
            $obj = new ChildMondialRelayDeliveryInsurance();
            $obj->hydrate($row);
            MondialRelayDeliveryInsuranceTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMondialRelayDeliveryInsurance|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
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
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
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
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::ID, $keys, Criteria::IN);
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
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::ID, $id, $comparison);
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
     * @param     mixed $level The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function filterByLevel($level = null, $comparison = null)
    {
        if (is_array($level)) {
            $useMinMax = false;
            if (isset($level['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::LEVEL, $level['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($level['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::LEVEL, $level['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::LEVEL, $level, $comparison);
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
     * @param     mixed $maxValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function filterByMaxValue($maxValue = null, $comparison = null)
    {
        if (is_array($maxValue)) {
            $useMinMax = false;
            if (isset($maxValue['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::MAX_VALUE, $maxValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxValue['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::MAX_VALUE, $maxValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::MAX_VALUE, $maxValue, $comparison);
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
     * @param     mixed $priceWithTax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function filterByPriceWithTax($priceWithTax = null, $comparison = null)
    {
        if (is_array($priceWithTax)) {
            $useMinMax = false;
            if (isset($priceWithTax['min'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::PRICE_WITH_TAX, $priceWithTax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceWithTax['max'])) {
                $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::PRICE_WITH_TAX, $priceWithTax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::PRICE_WITH_TAX, $priceWithTax, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMondialRelayDeliveryInsurance $mondialRelayDeliveryInsurance Object to remove from the list of results
     *
     * @return ChildMondialRelayDeliveryInsuranceQuery The current query, for fluid interface
     */
    public function prune($mondialRelayDeliveryInsurance = null)
    {
        if ($mondialRelayDeliveryInsurance) {
            $this->addUsingAlias(MondialRelayDeliveryInsuranceTableMap::ID, $mondialRelayDeliveryInsurance->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mondial_relay_delivery_insurance table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MondialRelayDeliveryInsuranceTableMap::clearInstancePool();
            MondialRelayDeliveryInsuranceTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMondialRelayDeliveryInsurance or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMondialRelayDeliveryInsurance object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MondialRelayDeliveryInsuranceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MondialRelayDeliveryInsuranceTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MondialRelayDeliveryInsuranceQuery
