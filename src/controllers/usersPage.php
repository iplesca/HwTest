<?php
/**
 * Users page. Display user related information
 */
class UsersPage extends PageController
{
    protected $layout = 'users.html';
    
    public function index()
    {
        $this->setTitle('User detail page');
    }
    /**
     * Shows all associated data of an user (direct friends, friends of friends, suggested friends and suggested cities)
     * @param int $userId 
     */
    public function info($userId)
    {
        $user = UserPeer::retrieveByPK($userId);
        
        // bad id, no result
        if ($user) {
            $this->setTitle('User detail page: ' . $user->getFullname());
            
            $this->data['userdata'] = $user->toArray(); 
            
            $this->data['friends']           = $user->getDirectFriends();
            $this->data['friendsOfFriends']  = $user->getFriendsOfFriends();
            $this->data['suggestedFriends']  = $user->getSuggestedFriends();
            $this->data['suggestedCities']   = $user->getSuggestedCities();
        }
    }
}