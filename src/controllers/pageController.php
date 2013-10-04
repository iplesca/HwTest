<?php
/**
 * Will serve as base page controller.
 * Defines a default layout, allows for a page main block.
 * Probably the next inheritance should be a DesktopPageController
 */
abstract class PageController
{
    /**
     * Silex\Application() object
     * @var object
     */
    protected $app = null;
    /**
     * Template engine
     * @var object
     */
    protected $tpl = null;
    /**
     * HTML page layout. Better be extended through Twig by the other layouts
     * @var string
     */
    protected $layout = 'main.html';
    /**
     * Data holder for Twig. A nicer Object[array] interface could be built. No time.
     * @var array
     */
    protected $data = array();
    /**
     * Adds the $app and template engine.
     * Fires index()
     * 
     * @param object Silex\Application $app
     * @param object Twig $tplEngine 
     */
    public function __construct($app, $tplEngine = null)
    {
        $this->app = $app;
        if (!is_null($tplEngine)) {
            $this->tpl = $tplEngine;
        } else {
            throw new Exception('No template engine provided');
        }
        
        // lets go
        $this->index();
    }
    /**
     * Every extending page must have an index() method.
     * Should serve as a pseudo-constructor
     */
    abstract public function index();
    /**
     * Adds a title var to the Twig $data array.
     * @param string $text 
     */
    public function setTitle($text)
    {
        $this->data['title'] = $text;
    }
    /**
     * Will run Twig rendering over the specified $layout
     * @return object
     */
    public function render()
    {
        return $this->tpl->render($this->layout, $this->data);
    }
}