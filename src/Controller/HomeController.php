<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: thomas.merlin@fidesio.com
 * Date: 11/06/2018
 * Time: 03:13
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        dump('bonjour'); die;
    }
}