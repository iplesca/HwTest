<?php



/**
 * This class defines the structure of the 'cities' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.hwtest_iplesca.map
 */
class CityTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'hwtest_iplesca.map.CityTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('cities');
        $this->setPhpName('City');
        $this->setClassname('City');
        $this->setPackage('hwtest_iplesca');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 5, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 60, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('VisitedCity', 'VisitedCity', RelationMap::ONE_TO_MANY, array('id' => 'cityId', ), 'CASCADE', 'CASCADE', 'VisitedCitys');
    } // buildRelations()

} // CityTableMap
