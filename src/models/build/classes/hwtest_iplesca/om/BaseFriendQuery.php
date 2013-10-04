<?php


/**
 * Base class that represents a query for the 'friends' table.
 *
 * Friends table defines 1:n relations of users
 *
 * @method FriendQuery orderById($order = Criteria::ASC) Order by the id column
 * @method FriendQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 * @method FriendQuery orderByFriendid($order = Criteria::ASC) Order by the friendId column
 *
 * @method FriendQuery groupById() Group by the id column
 * @method FriendQuery groupByUserid() Group by the userId column
 * @method FriendQuery groupByFriendid() Group by the friendId column
 *
 * @method FriendQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FriendQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FriendQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Friend findOne(PropelPDO $con = null) Return the first Friend matching the query
 * @method Friend findOneOrCreate(PropelPDO $con = null) Return the first Friend matching the query, or a new Friend object populated from the query conditions when no match is found
 *
 * @method Friend findOneByUserid(int $userId) Return the first Friend filtered by the userId column
 * @method Friend findOneByFriendid(int $friendId) Return the first Friend filtered by the friendId column
 *
 * @method array findById(int $id) Return Friend objects filtered by the id column
 * @method array findByUserid(int $userId) Return Friend objects filtered by the userId column
 * @method array findByFriendid(int $friendId) Return Friend objects filtered by the friendId column
 *
 * @package    propel.generator.hwtest_iplesca.om
 */
abstract class BaseFriendQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFriendQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'hwtest_iplesca', $modelName = 'Friend', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FriendQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FriendQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FriendQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FriendQuery) {
            return $criteria;
        }
        $query = new FriendQuery();
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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Friend|Friend[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FriendPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FriendPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Friend A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Friend A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `userId`, `friendId` FROM `friends` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Friend();
            $obj->hydrate($row);
            FriendPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Friend|Friend[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Friend[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return FriendQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FriendPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FriendQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FriendPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FriendQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FriendPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FriendPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FriendPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the userId column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userId = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userId IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userId >= 12
     * $query->filterByUserid(array('max' => 12)); // WHERE userId <= 12
     * </code>
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FriendQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(FriendPeer::USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(FriendPeer::USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FriendPeer::USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the friendId column
     *
     * Example usage:
     * <code>
     * $query->filterByFriendid(1234); // WHERE friendId = 1234
     * $query->filterByFriendid(array(12, 34)); // WHERE friendId IN (12, 34)
     * $query->filterByFriendid(array('min' => 12)); // WHERE friendId >= 12
     * $query->filterByFriendid(array('max' => 12)); // WHERE friendId <= 12
     * </code>
     *
     * @param     mixed $friendid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FriendQuery The current query, for fluid interface
     */
    public function filterByFriendid($friendid = null, $comparison = null)
    {
        if (is_array($friendid)) {
            $useMinMax = false;
            if (isset($friendid['min'])) {
                $this->addUsingAlias(FriendPeer::FRIENDID, $friendid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($friendid['max'])) {
                $this->addUsingAlias(FriendPeer::FRIENDID, $friendid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FriendPeer::FRIENDID, $friendid, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Friend $friend Object to remove from the list of results
     *
     * @return FriendQuery The current query, for fluid interface
     */
    public function prune($friend = null)
    {
        if ($friend) {
            $this->addUsingAlias(FriendPeer::ID, $friend->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // equal_nest behavior

    /**
     * Filter the query by 2 User objects for a Equal Nest Friend relation
     *
     * @param      User|integer $object1
     * @param      User|integer $object2
     * @return     FriendQuery Fluent API
     */
    public function filterByUsers($object1, $object2)
    {
        return $this
            ->condition('first-one', 'Friend.Userid = ?', is_object($object1) ? $object1->getPrimaryKey() : $object1)
            ->condition('first-two', 'Friend.Friendid = ?', is_object($object2) ? $object2->getPrimaryKey() : $object2)
            ->condition('second-one', 'Friend.Friendid = ?', is_object($object1) ? $object1->getPrimaryKey() : $object1)
            ->condition('second-two', 'Friend.Userid = ?', is_object($object2) ? $object2->getPrimaryKey() : $object2)
            ->combine(array('first-one',  'first-two'),  'AND', 'first')
            ->combine(array('second-one', 'second-two'), 'AND', 'second')
            ->where(array('first', 'second'), 'OR');
    }

}
