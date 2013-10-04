<?php
/**
 * FFast template of an 404 page. beta 0.1. Can be improved.
 */
class Show404Page extends PageController
{
    protected $layout = 'error.html';
    
    public function index()
    {
        $this->setTitle('Error page');
        $this->data['message'] = 'Terrible, terrible error :(';
    }
}