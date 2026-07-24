<?php

namespace MondialRelay\Model\Map;

use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
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
 * This class defines the structure of the 'mondial_relay_delivery_price' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class MondialRelayDeliveryPriceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'MondialRelay.Model.Map.MondialRelayDeliveryPriceTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'TheliaMain';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'mondial_relay_delivery_price';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'MondialRelayDeliveryPrice';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\MondialRelay\\Model\\MondialRelayDeliveryPrice';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'MondialRelay.Model.MondialRelayDeliveryPrice';

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
    public const COL_ID = 'mondial_relay_delivery_price.id';

    /**
     * the column name for the max_weight field
     */
    public const COL_MAX_WEIGHT = 'mondial_relay_delivery_price.max_weight';

    /**
     * the column name for the price_with_tax field
     */
    public const COL_PRICE_WITH_TAX = 'mondial_relay_delivery_price.price_with_tax';

    /**
     * the column name for the area_id field
     */
    public const COL_AREA_ID = 'mondial_relay_delivery_price.area_id';

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
        self::TYPE_PHPNAME       => ['Id', 'MaxWeight', 'PriceWithTax', 'AreaId', ],
        self::TYPE_CAMELNAME     => ['id', 'maxWeight', 'priceWithTax', 'areaId', ],
        self::TYPE_COLNAME       => [MondialRelayDeliveryPriceTableMap::COL_ID, MondialRelayDeliveryPriceTableMap::COL_MAX_WEIGHT, MondialRelayDeliveryPriceTableMap::COL_PRICE_WITH_TAX, MondialRelayDeliveryPriceTableMap::COL_AREA_ID, ],
        self::TYPE_FIELDNAME     => ['id', 'max_weight', 'price_with_tax', 'area_id', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'MaxWeight' => 1, 'PriceWithTax' => 2, 'AreaId' => 3, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'maxWeight' => 1, 'priceWithTax' => 2, 'areaId' => 3, ],
        self::TYPE_COLNAME       => [MondialRelayDeliveryPriceTableMap::COL_ID => 0, MondialRelayDeliveryPriceTableMap::COL_MAX_WEIGHT => 1, MondialRelayDeliveryPriceTableMap::COL_PRICE_WITH_TAX => 2, MondialRelayDeliveryPriceTableMap::COL_AREA_ID => 3, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'max_weight' => 1, 'price_with_tax' => 2, 'area_id' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'MondialRelayDeliveryPrice.Id' => 'ID',
        'id' => 'ID',
        'mondialRelayDeliveryPrice.id' => 'ID',
        'MondialRelayDeliveryPriceTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'mondial_relay_delivery_price.id' => 'ID',
        'MaxWeight' => 'MAX_WEIGHT',
        'MondialRelayDeliveryPrice.MaxWeight' => 'MAX_WEIGHT',
        'maxWeight' => 'MAX_WEIGHT',
        'mondialRelayDeliveryPrice.maxWeight' => 'MAX_WEIGHT',
        'MondialRelayDeliveryPriceTableMap::COL_MAX_WEIGHT' => 'MAX_WEIGHT',
        'COL_MAX_WEIGHT' => 'MAX_WEIGHT',
        'max_weight' => 'MAX_WEIGHT',
        'mondial_relay_delivery_price.max_weight' => 'MAX_WEIGHT',
        'PriceWithTax' => 'PRICE_WITH_TAX',
        'MondialRelayDeliveryPrice.PriceWithTax' => 'PRICE_WITH_TAX',
        'priceWithTax' => 'PRICE_WITH_TAX',
        'mondialRelayDeliveryPrice.priceWithTax' => 'PRICE_WITH_TAX',
        'MondialRelayDeliveryPriceTableMap::COL_PRICE_WITH_TAX' => 'PRICE_WITH_TAX',
        'COL_PRICE_WITH_TAX' => 'PRICE_WITH_TAX',
        'price_with_tax' => 'PRICE_WITH_TAX',
        'mondial_relay_delivery_price.price_with_tax' => 'PRICE_WITH_TAX',
        'AreaId' => 'AREA_ID',
        'MondialRelayDeliveryPrice.AreaId' => 'AREA_ID',
        'areaId' => 'AREA_ID',
        'mondialRelayDeliveryPrice.areaId' => 'AREA_ID',
        'MondialRelayDeliveryPriceTableMap::COL_AREA_ID' => 'AREA_ID',
        'COL_AREA_ID' => 'AREA_ID',
        'area_id' => 'AREA_ID',
        'mondial_relay_delivery_price.area_id' => 'AREA_ID',
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
        $this->setName('mondial_relay_delivery_price');
        $this->setPhpName('MondialRelayDeliveryPrice');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\MondialRelay\\Model\\MondialRelayDeliveryPrice');
        $this->setPackage('MondialRelay.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('max_weight', 'MaxWeight', 'DECIMAL', true, 16, 0.000000);
        $this->addColumn('price_with_tax', 'PriceWithTax', 'DECIMAL', true, 16, 0.000000);
        $this->addForeignKey('area_id', 'AreaId', 'INTEGER', 'area', 'id', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('Area', '\\Thelia\\Model\\Area', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':area_id',
    1 => ':id',
  ),
), 'CASCADE', 'RESTRICT', null, false);
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
        return $withPrefix ? MondialRelayDeliveryPriceTableMap::CLASS_DEFAULT : MondialRelayDeliveryPriceTableMap::OM_CLASS;
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
     * @return array (MondialRelayDeliveryPrice object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = MondialRelayDeliveryPriceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MondialRelayDeliveryPriceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MondialRelayDeliveryPriceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MondialRelayDeliveryPriceTableMap::OM_CLASS;
            /** @var MondialRelayDeliveryPrice $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MondialRelayDeliveryPriceTableMap::addInstanceToPool($obj, $key);
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
            $key = MondialRelayDeliveryPriceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MondialRelayDeliveryPriceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var MondialRelayDeliveryPrice $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MondialRelayDeliveryPriceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MondialRelayDeliveryPriceTableMap::COL_ID);
            $criteria->addSelectColumn(MondialRelayDeliveryPriceTableMap::COL_MAX_WEIGHT);
            $criteria->addSelectColumn(MondialRelayDeliveryPriceTableMap::COL_PRICE_WITH_TAX);
            $criteria->addSelectColumn(MondialRelayDeliveryPriceTableMap::COL_AREA_ID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.max_weight');
            $criteria->addSelectColumn($alias . '.price_with_tax');
            $criteria->addSelectColumn($alias . '.area_id');
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
            $criteria->removeSelectColumn(MondialRelayDeliveryPriceTableMap::COL_ID);
            $criteria->removeSelectColumn(MondialRelayDeliveryPriceTableMap::COL_MAX_WEIGHT);
            $criteria->removeSelectColumn(MondialRelayDeliveryPriceTableMap::COL_PRICE_WITH_TAX);
            $criteria->removeSelectColumn(MondialRelayDeliveryPriceTableMap::COL_AREA_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.max_weight');
            $criteria->removeSelectColumn($alias . '.price_with_tax');
            $criteria->removeSelectColumn($alias . '.area_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(MondialRelayDeliveryPriceTableMap::DATABASE_NAME)->getTable(MondialRelayDeliveryPriceTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a MondialRelayDeliveryPrice or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or MondialRelayDeliveryPrice object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryPriceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MondialRelay\Model\MondialRelayDeliveryPrice) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MondialRelayDeliveryPriceTableMap::DATABASE_NAME);
            $criteria->add(MondialRelayDeliveryPriceTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MondialRelayDeliveryPriceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MondialRelayDeliveryPriceTableMap::clearInstancePool();
        } elseif (!\is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MondialRelayDeliveryPriceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the mondial_relay_delivery_price table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return MondialRelayDeliveryPriceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MondialRelayDeliveryPrice or Criteria object.
     *
     * @param mixed $criteria Criteria or MondialRelayDeliveryPrice object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MondialRelayDeliveryPriceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MondialRelayDeliveryPrice object
        }

        if ($criteria->containsKey(MondialRelayDeliveryPriceTableMap::COL_ID) && $criteria->keyContainsValue(MondialRelayDeliveryPriceTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MondialRelayDeliveryPriceTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MondialRelayDeliveryPriceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
