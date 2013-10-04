<?php



/**
 * This class defines the structure of the 'visitedcities' table.
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
class VisitedCityTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'hwtest_iplesca.map.VisitedCityTableMap';

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
        $this->setName('visitedcities');
        $this->setPhpName('VisitedCity');
        $this->setClassname('VisitedCity');
        $this->setPackage('hwtest_iplesca');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addForeignKey('userId', 'Userid', 'INTEGER', 'users', 'id', true, 10, null);
        $this->addForeignKey('cityId', 'Cityid', 'INTEGER', 'cities', 'id', true, 5, null);
        $this->addColumn('rating', 'Rating', 'TINYINT', true, 2, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'User', RelationMap::MANY_TO_ONE, array('userId' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('City', 'City', RelationMap::MANY_TO_ONE, array('cityId' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

} // VisitedCityTableMap
