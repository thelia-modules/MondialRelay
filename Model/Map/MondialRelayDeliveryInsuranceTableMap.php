<?php

namespace MondialRelay\Model\Map;

use MondialRelay\Model\MondialRelayDeliveryInsurance;
use MondialRelay\Model\MondialRelayDeliveryInsuranceQuery;
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
 * This class defines the structure of the 'mondial_relay_delivery_insurance' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class MondialRelayDeliveryInsuranceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'MondialRelay.Model.Map.MondialRelayDeliveryInsuranceTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'TheliaMain';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'mondial_relay_delivery_insurance';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'MondialRelayDeliveryInsurance';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\MondialRelay\\Model\\MondialRelayDeliveryInsurance';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'MondialRelay.Model.MondialRelayDeliveryInsurance';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'mondial_relay_delivery_insurance.id';

    /**
     * the column name for the level field
     */
    public const COL_LEVEL = 'mondial_relay_delivery_insurance.level';

    /**
     * the column name for the max_value field
     */
    public const COL_MAX_VALUE = 'mondial_relay_delivery_insurance.max_value';

    /**
     * the column name for the price_with_tax field
     */
    public const COL_PRICE_WITH_TAX = 'mondial_relay_delivery_insurance.price_with_tax';

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
        self::TYPE_PHPNAME       => ['Id', 'Level', 'MaxValue', 'PriceWithTax', ],
        self::TYPE_CAMELNAME     => ['id', 'level', 'maxValue', 'priceWithTax', ],
        self::TYPE_COLNAME       => [MondialRelayDeliveryInsuranceTableMap::COL_ID, MondialRelayDeliveryInsuranceTableMap::COL_LEVEL, MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE, MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX, ],
        self::TYPE_FIELDNAME     => ['id', 'level', 'max_value', 'price_with_tax', ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Level' => 1, 'MaxValue' => 2, 'PriceWithTax' => 3, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'level' => 1, 'maxValue' => 2, 'priceWithTax' => 3, ],
        self::TYPE_COLNAME       => [MondialRelayDeliveryInsuranceTableMap::COL_ID => 0, MondialRelayDeliveryInsuranceTableMap::COL_LEVEL => 1, MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE => 2, MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX => 3, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'level' => 1, 'max_value' => 2, 'price_with_tax' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'MondialRelayDeliveryInsurance.Id' => 'ID',
        'id' => 'ID',
        'mondialRelayDeliveryInsurance.id' => 'ID',
        'MondialRelayDeliveryInsuranceTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'mondial_relay_delivery_insurance.id' => 'ID',
        'Level' => 'LEVEL',
        'MondialRelayDeliveryInsurance.Level' => 'LEVEL',
        'level' => 'LEVEL',
        'mondialRelayDeliveryInsurance.level' => 'LEVEL',
        'MondialRelayDeliveryInsuranceTableMap::COL_LEVEL' => 'LEVEL',
        'COL_LEVEL' => 'LEVEL',
        'mondial_relay_delivery_insurance.level' => 'LEVEL',
        'MaxValue' => 'MAX_VALUE',
        'MondialRelayDeliveryInsurance.MaxValue' => 'MAX_VALUE',
        'maxValue' => 'MAX_VALUE',
        'mondialRelayDeliveryInsurance.maxValue' => 'MAX_VALUE',
        'MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE' => 'MAX_VALUE',
        'COL_MAX_VALUE' => 'MAX_VALUE',
        'max_value' => 'MAX_VALUE',
        'mondial_relay_delivery_insurance.max_value' => 'MAX_VALUE',
        'PriceWithTax' => 'PRICE_WITH_TAX',
        'MondialRelayDeliveryInsurance.PriceWithTax' => 'PRICE_WITH_TAX',
        'priceWithTax' => 'PRICE_WITH_TAX',
        'mondialRelayDeliveryInsurance.priceWithTax' => 'PRICE_WITH_TAX',
        'MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX' => 'PRICE_WITH_TAX',
        'COL_PRICE_WITH_TAX' => 'PRICE_WITH_TAX',
        'price_with_tax' => 'PRICE_WITH_TAX',
        'mondial_relay_delivery_insurance.price_with_tax' => 'PRICE_WITH_TAX',
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
        $this->setName('mondial_relay_delivery_insurance');
        $this->setPhpName('MondialRelayDeliveryInsurance');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\MondialRelay\\Model\\MondialRelayDeliveryInsurance');
        $this->setPackage('MondialRelay.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('level', 'Level', 'INTEGER', true, null, null);
        $this->addColumn('max_value', 'MaxValue', 'DECIMAL', true, 16, 0.000000);
        $this->addColumn('price_with_tax', 'PriceWithTax', 'DECIMAL', true, 16, 0.000000);
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
        return $withPrefix ? MondialRelayDeliveryInsuranceTableMap::CLASS_DEFAULT : MondialRelayDeliveryInsuranceTableMap::OM_CLASS;
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
     * @return array (MondialRelayDeliveryInsurance object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = MondialRelayDeliveryInsuranceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MondialRelayDeliveryInsuranceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MondialRelayDeliveryInsuranceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MondialRelayDeliveryInsuranceTableMap::OM_CLASS;
            /** @var MondialRelayDeliveryInsurance $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MondialRelayDeliveryInsuranceTableMap::addInstanceToPool($obj, $key);
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
            $key = MondialRelayDeliveryInsuranceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MondialRelayDeliveryInsuranceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var MondialRelayDeliveryInsurance $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MondialRelayDeliveryInsuranceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_ID);
            $criteria->addSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_LEVEL);
            $criteria->addSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE);
            $criteria->addSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.level');
            $criteria->addSelectColumn($alias . '.max_value');
            $criteria->addSelectColumn($alias . '.price_with_tax');
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
            $criteria->removeSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_ID);
            $criteria->removeSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_LEVEL);
            $criteria->removeSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_MAX_VALUE);
            $criteria->removeSelectColumn(MondialRelayDeliveryInsuranceTableMap::COL_PRICE_WITH_TAX);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.level');
            $criteria->removeSelectColumn($alias . '.max_value');
            $criteria->removeSelectColumn($alias . '.price_with_tax');
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
        return Propel::getServiceContainer()->getDatabaseMap(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME)->getTable(MondialRelayDeliveryInsuranceTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a MondialRelayDeliveryInsurance or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or MondialRelayDeliveryInsurance object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MondialRelay\Model\MondialRelayDeliveryInsurance) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
            $criteria->add(MondialRelayDeliveryInsuranceTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MondialRelayDeliveryInsuranceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MondialRelayDeliveryInsuranceTableMap::clearInstancePool();
        } elseif (!\is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MondialRelayDeliveryInsuranceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the mondial_relay_delivery_insurance table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return MondialRelayDeliveryInsuranceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MondialRelayDeliveryInsurance or Criteria object.
     *
     * @param mixed $criteria Criteria or MondialRelayDeliveryInsurance object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryInsuranceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MondialRelayDeliveryInsurance object
        }

        if ($criteria->containsKey(MondialRelayDeliveryInsuranceTableMap::COL_ID) && $criteria->keyContainsValue(MondialRelayDeliveryInsuranceTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MondialRelayDeliveryInsuranceTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MondialRelayDeliveryInsuranceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
