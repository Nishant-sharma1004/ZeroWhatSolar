<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Common_model;

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
     * @var list<string>
     */
    protected $helpers = [];
    protected $data = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    var $Common_model;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->Common_model = new Common_model();
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $segments = $request->getUri()->getSegments();

        $menu_type = (isset($segments[2]) && $segments[2] == 'admin') ? 'admin' : 'main';
        $this->data['header_menus'] = load_sidebar_menus($menu_type);
        $site_setting = $this->Common_model->get_site_setting();
        foreach($site_setting as $value){
            $this->data['settings'][$value->setting_key] = $value->setting_value;
        }
        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = service('session');
    }
}
