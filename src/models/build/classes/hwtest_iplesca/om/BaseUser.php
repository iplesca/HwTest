<?php


/**
 * Base class that represents a row from the 'users' table.
 *
 * User table
 *
 * @package    propel.generator.hwtest_iplesca.om
 */
abstract class BaseUser extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'UserPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        UserPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the firstname field.
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the gender field.
     * @var        int
     */
    protected $gender;

    /**
     * The value for the age field.
     * @var        int
     */
    protected $age;

    /**
     * @var        PropelObjectCollection|VisitedCity[] Collection to store aggregation of VisitedCity objects.
     */
    protected $collVisitedCitys;
    protected $collVisitedCitysPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    // equal_nest_parent behavior

    /**
     * @var array List of PKs of Friend for this User */
    protected $listEqualNestFriendsPKs;

    /**
     * @var PropelObjectCollection User[] Collection to store Equal Nest Friend of this User */
    protected $collEqualNestFriends;

    /**
     * @var boolean Flag to prevent endless processing loop which occurs when 2 new objects are set as twins
     */
    protected $alreadyInEqualNestProcessing = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $visitedCitysScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->lastname = '';
    }

    /**
     * Initializes internal state of BaseUser object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [firstname] column value.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the [gender] column value.
     * 1 = male, 0 = female
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the [age] column value.
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = UserPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [firstname] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[] = UserPeer::FIRSTNAME;
        }


        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     *
     * @param string $v new value
     * @return User The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[] = UserPeer::LASTNAME;
        }


        return $this;
    } // setLastname()

    /**
     * Set the value of [gender] column.
     * 1 = male, 0 = female
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setGender($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->gender !== $v) {
            $this->gender = $v;
            $this->modifiedColumns[] = UserPeer::GENDER;
        }


        return $this;
    } // setGender()

    /**
     * Set the value of [age] column.
     *
     * @param int $v new value
     * @return User The current object (for fluent API support)
     */
    public function setAge($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->age !== $v) {
            $this->age = $v;
            $this->modifiedColumns[] = UserPeer::AGE;
        }


        return $this;
    } // setAge()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->lastname !== '') {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->firstname = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->lastname = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->gender = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->age = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = UserPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating User object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collVisitedCitys = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = UserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                // equal_nest_parent behavior
                $this->processEqualNestQueries($con);

                UserPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->visitedCitysScheduledForDeletion !== null) {
                if (!$this->visitedCitysScheduledForDeletion->isEmpty()) {
                    VisitedCityQuery::create()
                        ->filterByPrimaryKeys($this->visitedCitysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->visitedCitysScheduledForDeletion = null;
                }
            }

            if ($this->collVisitedCitys !== null) {
                foreach ($this->collVisitedCitys as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = UserPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(UserPeer::FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`firstname`';
        }
        if ($this->isColumnModified(UserPeer::LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = '`lastname`';
        }
        if ($this->isColumnModified(UserPeer::GENDER)) {
            $modifiedColumns[':p' . $index++]  = '`gender`';
        }
        if ($this->isColumnModified(UserPeer::AGE)) {
            $modifiedColumns[':p' . $index++]  = '`age`';
        }

        $sql = sprintf(
            'INSERT INTO `users` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`firstname`':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case '`lastname`':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case '`gender`':
                        $stmt->bindValue($identifier, $this->gender, PDO::PARAM_INT);
                        break;
                    case '`age`':
                        $stmt->bindValue($identifier, $this->age, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collVisitedCitys !== null) {
                    foreach ($this->collVisitedCitys as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFirstname();
                break;
            case 2:
                return $this->getLastname();
                break;
            case 3:
                return $this->getGender();
                break;
            case 4:
                return $this->getAge();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
        $keys = UserPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFirstname(),
            $keys[2] => $this->getLastname(),
            $keys[3] => $this->getGender(),
            $keys[4] => $this->getAge(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collVisitedCitys) {
                $result['VisitedCitys'] = $this->collVisitedCitys->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFirstname($value);
                break;
            case 2:
                $this->setLastname($value);
                break;
            case 3:
                $this->setGender($value);
                break;
            case 4:
                $this->setAge($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = UserPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFirstname($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setLastname($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setGender($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAge($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);

        if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
        if ($this->isColumnModified(UserPeer::FIRSTNAME)) $criteria->add(UserPeer::FIRSTNAME, $this->firstname);
        if ($this->isColumnModified(UserPeer::LASTNAME)) $criteria->add(UserPeer::LASTNAME, $this->lastname);
        if ($this->isColumnModified(UserPeer::GENDER)) $criteria->add(UserPeer::GENDER, $this->gender);
        if ($this->isColumnModified(UserPeer::AGE)) $criteria->add(UserPeer::AGE, $this->age);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(UserPeer::DATABASE_NAME);
        $criteria->add(UserPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of User (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setGender($this->getGender());
        $copyObj->setAge($this->getAge());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getVisitedCitys() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addVisitedCity($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return UserPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new UserPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('VisitedCity' == $relationName) {
            $this->initVisitedCitys();
        }
    }

    /**
     * Clears out the collVisitedCitys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return User The current object (for fluent API support)
     * @see        addVisitedCitys()
     */
    public function clearVisitedCitys()
    {
        $this->collVisitedCitys = null; // important to set this to null since that means it is uninitialized
        $this->collVisitedCitysPartial = null;

        return $this;
    }

    /**
     * reset is the collVisitedCitys collection loaded partially
     *
     * @return void
     */
    public function resetPartialVisitedCitys($v = true)
    {
        $this->collVisitedCitysPartial = $v;
    }

    /**
     * Initializes the collVisitedCitys collection.
     *
     * By default this just sets the collVisitedCitys collection to an empty array (like clearcollVisitedCitys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initVisitedCitys($overrideExisting = true)
    {
        if (null !== $this->collVisitedCitys && !$overrideExisting) {
            return;
        }
        $this->collVisitedCitys = new PropelObjectCollection();
        $this->collVisitedCitys->setModel('VisitedCity');
    }

    /**
     * Gets an array of VisitedCity objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|VisitedCity[] List of VisitedCity objects
     * @throws PropelException
     */
    public function getVisitedCitys($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collVisitedCitysPartial && !$this->isNew();
        if (null === $this->collVisitedCitys || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collVisitedCitys) {
                // return empty collection
                $this->initVisitedCitys();
            } else {
                $collVisitedCitys = VisitedCityQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collVisitedCitysPartial && count($collVisitedCitys)) {
                      $this->initVisitedCitys(false);

                      foreach($collVisitedCitys as $obj) {
                        if (false == $this->collVisitedCitys->contains($obj)) {
                          $this->collVisitedCitys->append($obj);
                        }
                      }

                      $this->collVisitedCitysPartial = true;
                    }

                    $collVisitedCitys->getInternalIterator()->rewind();
                    return $collVisitedCitys;
                }

                if($partial && $this->collVisitedCitys) {
                    foreach($this->collVisitedCitys as $obj) {
                        if($obj->isNew()) {
                            $collVisitedCitys[] = $obj;
                        }
                    }
                }

                $this->collVisitedCitys = $collVisitedCitys;
                $this->collVisitedCitysPartial = false;
            }
        }

        return $this->collVisitedCitys;
    }

    /**
     * Sets a collection of VisitedCity objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $visitedCitys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return User The current object (for fluent API support)
     */
    public function setVisitedCitys(PropelCollection $visitedCitys, PropelPDO $con = null)
    {
        $visitedCitysToDelete = $this->getVisitedCitys(new Criteria(), $con)->diff($visitedCitys);

        $this->visitedCitysScheduledForDeletion = unserialize(serialize($visitedCitysToDelete));

        foreach ($visitedCitysToDelete as $visitedCityRemoved) {
            $visitedCityRemoved->setUser(null);
        }

        $this->collVisitedCitys = null;
        foreach ($visitedCitys as $visitedCity) {
            $this->addVisitedCity($visitedCity);
        }

        $this->collVisitedCitys = $visitedCitys;
        $this->collVisitedCitysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related VisitedCity objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related VisitedCity objects.
     * @throws PropelException
     */
    public function countVisitedCitys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collVisitedCitysPartial && !$this->isNew();
        if (null === $this->collVisitedCitys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collVisitedCitys) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getVisitedCitys());
            }
            $query = VisitedCityQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collVisitedCitys);
    }

    /**
     * Method called to associate a VisitedCity object to this object
     * through the VisitedCity foreign key attribute.
     *
     * @param    VisitedCity $l VisitedCity
     * @return User The current object (for fluent API support)
     */
    public function addVisitedCity(VisitedCity $l)
    {
        if ($this->collVisitedCitys === null) {
            $this->initVisitedCitys();
            $this->collVisitedCitysPartial = true;
        }
        if (!in_array($l, $this->collVisitedCitys->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddVisitedCity($l);
        }

        return $this;
    }

    /**
     * @param	VisitedCity $visitedCity The visitedCity object to add.
     */
    protected function doAddVisitedCity($visitedCity)
    {
        $this->collVisitedCitys[]= $visitedCity;
        $visitedCity->setUser($this);
    }

    /**
     * @param	VisitedCity $visitedCity The visitedCity object to remove.
     * @return User The current object (for fluent API support)
     */
    public function removeVisitedCity($visitedCity)
    {
        if ($this->getVisitedCitys()->contains($visitedCity)) {
            $this->collVisitedCitys->remove($this->collVisitedCitys->search($visitedCity));
            if (null === $this->visitedCitysScheduledForDeletion) {
                $this->visitedCitysScheduledForDeletion = clone $this->collVisitedCitys;
                $this->visitedCitysScheduledForDeletion->clear();
            }
            $this->visitedCitysScheduledForDeletion[]= clone $visitedCity;
            $visitedCity->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related VisitedCitys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|VisitedCity[] List of VisitedCity objects
     */
    public function getVisitedCitysJoinCity($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = VisitedCityQuery::create(null, $criteria);
        $query->joinWith('City', $join_behavior);

        return $this->getVisitedCitys($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->gender = null;
        $this->age = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collVisitedCitys) {
                foreach ($this->collVisitedCitys as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        // equal_nest_parent behavior

        if ($deep) {
            if ($this->collEqualNestFriends) {
                foreach ($this->collEqualNestFriends as $obj) {
                    $obj->clearAllReferences($deep);
                }
            }
        }

        $this->listEqualNestFriendsPKs = null;
        $this->collEqualNestFriends = null;

        if ($this->collVisitedCitys instanceof PropelCollection) {
            $this->collVisitedCitys->clearIterator();
        }
        $this->collVisitedCitys = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // equal_nest_parent behavior

    /**
     * This function checks the local equal nest collection against the database
     * and creates new relations or deletes ones that have been removed
     *
     * @param PropelPDO $con
     */
    public function processEqualNestQueries(PropelPDO $con = null)
    {
        if (false === $this->alreadyInEqualNestProcessing && null !== $this->collEqualNestFriends) {
            $this->alreadyInEqualNestProcessing = true;

            if (null === $con) {
                $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
            }

            $this->clearListFriendsPKs();
            $this->initListFriendsPKs($con);

            foreach ($this->collEqualNestFriends as $aFriend) {
                if (!$aFriend->isDeleted() && ($aFriend->isNew() || $aFriend->isModified())) {
                    $aFriend->save($con);
                }
            }

            $con->beginTransaction();

            try {
                foreach ($this->getFriends()->getPrimaryKeys($usePrefix = false) as $columnKey => $pk) {
                    if (!in_array($pk, $this->listEqualNestFriendsPKs)) {
                        // save new equal nest relation
                        FriendPeer::buildEqualNestFriendRelation($this, $pk, $con);
                        // add this object to the sibling's collection
                        $this->getFriends()->get($columnKey)->addFriend($this);
                    } else {
                        // remove the pk from the list of db keys
                        unset($this->listEqualNestFriendsPKs[array_search($pk, $this->listEqualNestFriendsPKs)]);
                    }
                }

                // if we have keys still left, this means they are relations that have to be removed
                foreach ($this->listEqualNestFriendsPKs as $oldPk) {
                    FriendPeer::removeEqualNestFriendRelation($this, $oldPk, $con);
                }

                $con->commit();
            } catch (PropelException $e) {
                $con->rollBack();
                throw $e;
            }

            $this->alreadyInEqualNestProcessing = false;
        }
    }

    /**
     * Clears out the list of Equal Nest Friends PKs
     */
    public function clearListFriendsPKs()
    {
        $this->listEqualNestFriendsPKs = null;
    }

    /**
     * Initializes the list of Equal Nest Friends PKs.
     *
     * This will query the database for Equal Nest Friends relations to this User object.
     * It will set the list to an empty array if the object is newly created.
     *
     * @param PropelPDO $con
     */
    protected function initListFriendsPKs(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (null === $this->listEqualNestFriendsPKs) {
            if ($this->isNew()) {
                $this->listEqualNestFriendsPKs = array();
            } else {
                $sql = "
    SELECT DISTINCT users.id
    FROM users
    INNER JOIN friends ON
    users.id = friends.userId
    OR
    users.id = friends.friendId
    WHERE
    users.id IN (
        SELECT friends.userId
        FROM friends
        WHERE friends.friendId = ?
    )
    OR
    users.id IN (
        SELECT friends.friendId
        FROM friends
        WHERE friends.userId = ?
    )";

                $stmt = $con->prepare($sql);
                $stmt->bindValue(1, $this->getPrimaryKey(), PDO::PARAM_INT);
                $stmt->bindValue(2, $this->getPrimaryKey(), PDO::PARAM_INT);
                $stmt->execute();

                $this->listEqualNestFriendsPKs = $stmt->fetchAll(PDO::FETCH_COLUMN);
            }
        }
    }

    /**
     * Clears out the collection of Equal Nest Friends *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to the accessor method.
     *
     * @see addFriend()
     * @see setFriends()
     * @see removeFriends()
     */
    public function clearFriends()
    {
        $this->collEqualNestFriends = null;
    }

    /**
     * Initializes the collEqualNestFriends collection.
     *
     * By default this just sets the collEqualNestFriends collection to an empty PropelObjectCollection;
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database (ie, calling getFriends).
     */
    protected function initFriends()
    {
        $this->collEqualNestFriends = new PropelObjectCollection();
        $this->collEqualNestFriends->setModel('User');
    }

    /**
     * Removes all Equal Nest Friends relations
     *
     * @see addFriend()
     * @see setFriends()
     */
    public function removeFriends()
    {
        foreach ($this->getFriends() as $obj) {
            $obj->removeFriend($this);
        }
    }

    /**
     * Gets an array of User objects which are Equal Nest Friends of this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User object is new, it will return an empty collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return     PropelObjectCollection User[] List of Equal Nest Friends of this User.
     * @throws     PropelException
     */
    public function getFriends(Criteria $criteria = null, PropelPDO $con = null)
    {
        if (null === $this->listEqualNestFriendsPKs) {
            $this->initListFriendsPKs($con);
        }

        if (null === $this->collEqualNestFriends || null !== $criteria) {
            if (0 === count($this->listEqualNestFriendsPKs) && null === $this->collEqualNestFriends) {
                // return empty collection
                $this->initFriends();
            } else {
                $newCollection = UserQuery::create(null, $criteria)
                    ->addUsingAlias(UserPeer::ID, $this->listEqualNestFriendsPKs, Criteria::IN)
                    ->find($con);

                if (null !== $criteria) {
                    return $newCollection;
                }

                $this->collEqualNestFriends = $newCollection;
            }
        }

        return $this->collEqualNestFriends;
    }

    /**
     * Set an array of User objects as Friends of the this object
     *
     * @param  User[] $objects The User objects to set as Friends of the current object
     * @throws PropelException
     * @see    addFriend()
     */
    public function setFriends($objects)
    {
        $this->clearFriends();
        foreach ($objects as $aFriend) {
            if (!$aFriend instanceof User) {
                throw new PropelException(sprintf(
                    '[Equal Nest] Cannot set object of type %s as Friend, expected User',
                    is_object($aFriend) ? get_class($aFriend) : gettype($aFriend)
                ));
            }

            $this->addFriend($aFriend);
        }
    }

    /**
     * Checks for Equal Nest relation
     *
     * @param  User $aFriend The object to check for Equal Nest Friend relation to the current object
     * @return boolean
     */
    public function hasFriend(User $aFriend)
    {
        if (null === $this->collEqualNestFriends) {
            $this->getFriends();
        }

        return $aFriend->isNew() || $this->isNew()
            ? in_array($aFriend, $this->collEqualNestFriends->getArrayCopy())
            : in_array($aFriend->getPrimaryKey(), $this->collEqualNestFriends->getPrimaryKeys());
    }

    /**
     * Method called to associate another User object as a Friend of this one
     * through the Equal Nest Friends relation.
     *
     * @param  User $aFriend The User object to set as Equal Nest Friends relation of the current object
     * @throws PropelException
     */
    public function addFriend(User $aFriend)
    {
        if (!$this->hasFriend($aFriend)) {
            $this->collEqualNestFriends[] = $aFriend;
            $aFriend->addFriend($this);
        }
    }

    /**
     * Method called to associate multiple User objects as Equal Nest Friends of this one
     *
     * @param   User[] Friends The User objects to set as
     *          Equal Nest Friends relation of the current object.
     * @throws  PropelException
     */
    public function addFriends($Friends)
    {
        foreach ($Friends as $aFriends) {
            $this->addFriend($aFriends);
        }
    }

    /**
     * Method called to remove a User object from the Equal Nest Friends relation
     *
     * @param  User $friend The User object
     *         to remove as a Friend of the current object
     * @param  PropelPDO $con
     * @throws PropelException
     */
    public function removeFriend(User $friend, PropelPDO $con = null)
    {
        if (null === $this->collEqualNestFriends) {
            $this->getFriends(null, $con);
        }

        if ($this->collEqualNestFriends->contains($friend)) {
            $this->collEqualNestFriends->remove($this->collEqualNestFriends->search($friend));

            $coll = $friend->getFriends(null, $con);
            if ($coll->contains($this)) {
                $coll->remove($coll->search($this));
            }
        } else {
            throw new PropelException(sprintf('[Equal Nest] Cannot remove Friend from Equal Nest relation because it is not set as one!'));
        }
    }

    /**
     * Returns the number of Equal Nest Friends of this object.
     *
     * @param      Criteria   $criteria
     * @param      boolean    $distinct
     * @param      PropelPDO  $con
     * @return     integer    Count of Friends
     * @throws     PropelException
     */
    public function countFriends(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->listEqualNestFriendsPKs) {
            $this->initListFriendsPKs($con);
        }

        if (null === $this->collEqualNestFriends || null !== $criteria) {
            if ($this->isNew() && null === $this->collEqualNestFriends) {
                return 0;
            } else {
                $query = UserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->addUsingAlias(UserPeer::ID, $this->listEqualNestFriendsPKs, Criteria::IN)
                    ->count($con);
            }
        } else {
            return count($this->collEqualNestFriends);
        }
    }

}
