<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        date_default_timezone_set('Europe/Kyiv');

        //For CLI commands
        if (!isset($_SERVER['HTTP_HOST'])){
            return;
        }

        $user = new UserModel();
        $user = $user->get();

        if ($_SERVER['REQUEST_URI'] == '/test'){
            return;
        }

        //CRON
        if ($_SERVER['REQUEST_URI'] == '/cron/c2min'){
            return;
        }

        //change orders status
        if ($_SERVER['REQUEST_URI'] == '/change-status'){
            return;
        }

        //update card balance
        if ($_SERVER['REQUEST_URI'] == '/get-current-balance'){
            return;
        }

        //update card balance
        if ($_SERVER['REQUEST_URI'] == '/set-current-balance'){
            return;
        }

        $matches = null;
        //for list shops
        preg_match('/([0-9]+)/', $_SERVER['REQUEST_URI'], $matches);
        if ($matches){
            return;
        }

        if ($_SERVER['REQUEST_URI'] == '/'){
            return;
        }

        if (($_SERVER['REDIRECT_URL'] == '/login') || ($_SERVER['REDIRECT_URL'] == '/logout')){
            return;
        }

        if ($_SERVER['REQUEST_URI'] == '/game/login' && !$user){
            return;
        }

        if ($_SERVER['REQUEST_URI'] == '/game' && !$user){
            header('Location: /game/login');
            die;
        }

        if ($_SERVER['REQUEST_URI'] == '/game' && $user){
            return;
        }

        if (!$user){
            header('Location: /login');
            die;
        }

        if ($_SERVER['REQUEST_URI'] == '/game' && $user){
            return;
        }


        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

    }

    private function checkGame(){

    }

    private function checkDna(){

    }



}
