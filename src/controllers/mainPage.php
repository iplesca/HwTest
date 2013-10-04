<?php
/**
 * Main page. Shows all the users.
 */
class MainPage extends PageController
{
    protected $layout = 'main.html';
    
    public function index()
    {
        $this->setTitle('Main page');
        $this->showUsers();
    }
    public function showUsers()
    {
        // get all the users ordered by full name
        $users = UserQuery::create()->orderByFirstname()->orderByLastname()->find();
        $this->data['users'] = $users->toArray(); 
    }
}