<?php



/**
 * This class defines the structure of the 'users' table.
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
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'hwtest_iplesca.map.UserTableMap';

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
        $this->setName('users');
        $this->setPhpName('User');
        $this->setClassname('User');
        $this->setPackage('hwtest_iplesca');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('firstname', 'Firstname', 'VARCHAR', true, 50, null);
        $this->addColumn('lastname', 'Lastname', 'VARCHAR', false, 50, '');
        $this->addColumn('gender', 'Gender', 'TINYINT', true, 2, null);
        $this->addColumn('age', 'Age', 'INTEGER', true, 3, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('VisitedCity', 'VisitedCity', RelationMap::ONE_TO_MANY, array('id' => 'userId', ), 'CASCADE', 'CASCADE', 'VisitedCitys');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'equal_nest_parent' =>  array (
  'middle_table' => 'friends',
),
        );
    } // getBehaviors()

} // UserTableMap
