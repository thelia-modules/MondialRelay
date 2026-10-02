<?php

namespace MondialRelay\Model\Map;

use MondialRelay\Model\MondialRelayPickupAddress;
use MondialRelay\Model\MondialRelayPickupAddressQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'mondial_relay_pickup_address' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class MondialRelayPickupAddressTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'MondialRelay.Model.Map.MondialRelayPickupAddressTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'TheliaMain';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'mondial_relay_pickup_address';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'MondialRelayPickupAddress';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\MondialRelay\\Model\\MondialRelayPickupAddress';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'MondialRelay.Model.MondialRelayPickupAddress';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 3;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 3;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'mondial_relay_pickup_address.id';

    /**
     * the column name for the json_relay_data field
     */
    public const COL_JSON_RELAY_DATA = 'mondial_relay_pickup_address.json_relay_data';

    /**
     * the column name for the order_address_id field
     */
    public const COL_ORDER_ADDRESS_ID = 'mondial_relay_pickup_address.order_address_id';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'JsonRelayData', 'OrderAddressId', ],
        self::TYPE_CAMELNAME     => ['id', 'jsonRelayData', 'orderAddressId', ],
        self::TYPE_COLNAME       => [MondialRelayPickupAddressTableMap::COL_ID, MondialRelayPickupAddressTableMap::COL_JSON_RELAY_DATA, MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID, ],
        self::TYPE_FIELDNAME     => ['id', 'json_relay_data', 'order_address_id', ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'JsonRelayData' => 1, 'OrderAddressId' => 2, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'jsonRelayData' => 1, 'orderAddressId' => 2, ],
        self::TYPE_COLNAME       => [MondialRelayPickupAddressTableMap::COL_ID => 0, MondialRelayPickupAddressTableMap::COL_JSON_RELAY_DATA => 1, MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID => 2, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'json_relay_data' => 1, 'order_address_id' => 2, ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'MondialRelayPickupAddress.Id' => 'ID',
        'id' => 'ID',
        'mondialRelayPickupAddress.id' => 'ID',
        'MondialRelayPickupAddressTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'mondial_relay_pickup_address.id' => 'ID',
        'JsonRelayData' => 'JSON_RELAY_DATA',
        'MondialRelayPickupAddress.JsonRelayData' => 'JSON_RELAY_DATA',
        'jsonRelayData' => 'JSON_RELAY_DATA',
        'mondialRelayPickupAddress.jsonRelayData' => 'JSON_RELAY_DATA',
        'MondialRelayPickupAddressTableMap::COL_JSON_RELAY_DATA' => 'JSON_RELAY_DATA',
        'COL_JSON_RELAY_DATA' => 'JSON_RELAY_DATA',
        'json_relay_data' => 'JSON_RELAY_DATA',
        'mondial_relay_pickup_address.json_relay_data' => 'JSON_RELAY_DATA',
        'OrderAddressId' => 'ORDER_ADDRESS_ID',
        'MondialRelayPickupAddress.OrderAddressId' => 'ORDER_ADDRESS_ID',
        'orderAddressId' => 'ORDER_ADDRESS_ID',
        'mondialRelayPickupAddress.orderAddressId' => 'ORDER_ADDRESS_ID',
        'MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID' => 'ORDER_ADDRESS_ID',
        'COL_ORDER_ADDRESS_ID' => 'ORDER_ADDRESS_ID',
        'order_address_id' => 'ORDER_ADDRESS_ID',
        'mondial_relay_pickup_address.order_address_id' => 'ORDER_ADDRESS_ID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('mondial_relay_pickup_address');
        $this->setPhpName('MondialRelayPickupAddress');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\MondialRelay\\Model\\MondialRelayPickupAddress');
        $this->setPackage('MondialRelay.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('json_relay_data', 'JsonRelayData', 'CLOB', true, null, null);
        $this->addColumn('order_address_id', 'OrderAddressId', 'INTEGER', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? MondialRelayPickupAddressTableMap::CLASS_DEFAULT : MondialRelayPickupAddressTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (MondialRelayPickupAddress object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = MondialRelayPickupAddressTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MondialRelayPickupAddressTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MondialRelayPickupAddressTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MondialRelayPickupAddressTableMap::OM_CLASS;
            /** @var MondialRelayPickupAddress $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MondialRelayPickupAddressTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = MondialRelayPickupAddressTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MondialRelayPickupAddressTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var MondialRelayPickupAddress $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MondialRelayPickupAddressTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(MondialRelayPickupAddressTableMap::COL_ID);
            $criteria->addSelectColumn(MondialRelayPickupAddressTableMap::COL_JSON_RELAY_DATA);
            $criteria->addSelectColumn(MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.json_relay_data');
            $criteria->addSelectColumn($alias . '.order_address_id');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(MondialRelayPickupAddressTableMap::COL_ID);
            $criteria->removeSelectColumn(MondialRelayPickupAddressTableMap::COL_JSON_RELAY_DATA);
            $criteria->removeSelectColumn(MondialRelayPickupAddressTableMap::COL_ORDER_ADDRESS_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.json_relay_data');
            $criteria->removeSelectColumn($alias . '.order_address_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(MondialRelayPickupAddressTableMap::DATABASE_NAME)->getTable(MondialRelayPickupAddressTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a MondialRelayPickupAddress or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or MondialRelayPickupAddress object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayPickupAddressTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MondialRelay\Model\MondialRelayPickupAddress) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MondialRelayPickupAddressTableMap::DATABASE_NAME);
            $criteria->add(MondialRelayPickupAddressTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MondialRelayPickupAddressQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MondialRelayPickupAddressTableMap::clearInstancePool();
        } elseif (!\is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MondialRelayPickupAddressTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the mondial_relay_pickup_address table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return MondialRelayPickupAddressQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MondialRelayPickupAddress or Criteria object.
     *
     * @param mixed $criteria Criteria or MondialRelayPickupAddress object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayPickupAddressTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MondialRelayPickupAddress object
        }

        if ($criteria->containsKey(MondialRelayPickupAddressTableMap::COL_ID) && $criteria->keyContainsValue(MondialRelayPickupAddressTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MondialRelayPickupAddressTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MondialRelayPickupAddressQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
