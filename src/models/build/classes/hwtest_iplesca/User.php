<?php
/**
 * User table class.
 * All the magic happends here.
 * 
 * 
 * @package    propel.generator.hwtest_iplesca
 */
class User extends BaseUser
{
    /**
     * Minimum number of direct of friend to be known by a friend of friends
     */
    const MIN_DIRECT_FRIENDS = 2;
    /**
     * An unvisited city must be visited by at least X friends to become a suggested city
     */
    const MIN_REF_CITY       = 2;
    
    /**
     * Shorthand method
     * @return string
     */
    public function getFullname()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }
    /**
     * Returns the 1st level of friends of the current user, $this
     *
     * @param bool $flat
     * @param string $key
     * @return array
     */
    public function getDirectFriends($flat = true, $key = 'id')
    {
        $result = $this->getFriends();
        if ($flat) {
            $result = $result->toArray($key);
        }
        
        // nice to sort
        uasort($result, array($this, 'sortByFullname'));
        return $result;
    }
    /**
     * Gets the 2nd level of friends of the current user.
     *
     * @return array
     */
    public function getFriendsOfFriends()
    {
        $result = array();
        foreach ($this->getFriends() as $friend) {
            
            $extraFriends = array_diff_assoc($friend->getFriends()->toArray('id'), $result);
            $result = $extraFriends + $result;
        }
        
        // clean-up the direct friends and potentially the user itself
        $result = array_diff_assoc($result, $this->getDirectFriends());
        unset($result[ $this->getId() ]);
        
        uasort($result, array($this, 'sortByFullname'));
        return $result;
    }
    /**
     * A suggested friend is a friend-Of-Friends that might know at least another direct-Friend
     */
    public function getSuggestedFriends()
    {
        $result = array();
        
        $friendsOfFriends = $this->getFriendsOfFriends();
        $directFriends = $this->getDirectFriends();
        
        foreach ($friendsOfFriends as $flatFriend) {
            $friend = UserPeer::retrieveByPK($flatFriend['Id']);
            if (self::MIN_DIRECT_FRIENDS <= count(array_intersect_assoc($friend->getDirectFriends(), $directFriends))) {
                array_push($result, $friend->toArray());
            }
        }
        
        return $result;
    }
    /**
     * Useful method. Does what it says for the current user.
     *
     * @param bool $flat
     * @return array
     */
    public function getUnvisitedCities($flat = true)
    {
        $result = CityQuery::create()
                ->filterById($this->getVisitedCitys()->toKeyValue('Id', 'CityId'), Criteria::NOT_IN)
                ->find();
        if ($flat) {
            $result = $result->toArray();
        }
        return $result;
    }
    /**
     * Gets the suggested cities to visit for the current user.
     * The algorithm will:
     * - look for the unvisited cities of the current user
     * - check them against direct-Friends visited-Cities rating
     * - sums the rating grouped by city, counts max friends that visited this city
     * - calculates the rating based on rating sum divided by max friends that have visited ANY city
     * The rationale behind is that the average opinion/rating of 3 friends is better then the nice opinion of only 2. That's how I would do :)
     * 
     * @return array
     */
    public function getSuggestedCities()
    {
        $result = array();
        
        $unvisitedCities = $this->getUnvisitedCities(false);
        
        $q = new VisitedCityQuery();
        $possibleCities = $q->filterByCity($unvisitedCities)
                            ->filterByUser($this->getFriends())
                            ->joinCity()
                            ->find();
        
        if (!empty($possibleCities)) {
            $result = array();
            $maxFriends = 0;
            
            $cScoring = array(
                'Rating'       => 0,
                'TotalRating'  => 0,
                'TotalFriends' => 0,
                'CityId'       => null
            );
            foreach ($possibleCities->toArray() as $pc) {
                $cityId = $pc['Cityid'];
                
                if (!isset($result[ $cityId ])) {
                    $result[ $cityId ] = $cScoring;
                }
                
                $result[ $cityId ]['TotalRating'] += (0 == $pc['Rating'] ? 100 : $pc['Rating']);
                $result[ $cityId ]['TotalFriends']++;
                $result[ $cityId ]['CityId'] = $cityId;
                
                if ($result[ $cityId ]['TotalFriends'] > $maxFriends) {
                    $maxFriends = $result[ $cityId ]['TotalFriends'];
                }
            }
            $cityNames = $unvisitedCities->toKeyValue('Id', 'Name');
            foreach ($result as $k => &$city) {
                if (self::MIN_REF_CITY <= $city['TotalFriends']) {
                    $city['Rating'] = number_format($city['TotalRating'] / $maxFriends, 2);
                    $city['Name']   = $cityNames[$city['CityId']];
                } else {
                    unset($result[$k]);
                }
            }
            
            usort($result, function ($a, $b) {
                if ($a['Rating'] == $b['Rating']) {
                    return 0;
                }
                return $a['Rating'] > $b['Rating'] ? -1 : 1;
            });
        }
        
        return $result;
    }
    private function sortByFullname($a, $b)
    {
        $name1 = $a['Firstname'] . ' ' . $a['Lastname'];
        $name2 = $b['Firstname'] . ' ' . $b['Lastname'];
        
        if ($name1 == $name2) {
            return 0;
        }
        return ($name1 < $name2) ? -1 : 1;

    }
}
