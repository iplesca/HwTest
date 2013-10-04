<?php



/**
 * This class defines the structure of the 'friends' table.
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
class FriendTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'hwtest_iplesca.map.FriendTableMap';

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
        $this->setName('friends');
        $this->setPhpName('Friend');
        $this->setClassname('Friend');
        $this->setPackage('hwtest_iplesca');
        $this->setUseIdGenerator(true);
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 10, null);
        $this->addColumn('userId', 'Userid', 'INTEGER', true, 10, null);
        $this->addColumn('friendId', 'Friendid', 'INTEGER', true, 10, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
            'equal_nest' =>  array (
  'parent_table' => 'users',
  'reference_column_1' => 'userId',
  'reference_column_2' => 'friendId',
),
        );
    } // getBehaviors()

} // FriendTableMap
