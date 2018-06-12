<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: thomas.merlin@fidesio.com
 * Date: 11/06/2018
 * Time: 03:24
 */

namespace App\Controller;

use App\Forms\Type\AuthenticationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends Controller
{
    /**
     * Login function to access the secured area.
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $lastError = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $authenticationForm = $this->createForm(
            AuthenticationType::class,
            [],
            array(
                'lastUsername' => $lastUsername
            )
        );

        return $this->render(
            'pages/Security/login.html.twig',
            array(
                'lastError' => $lastError,
                'lastUsername' => $lastUsername,
                'authenticationForm' => $authenticationForm->createView()
            )
        );
    }
}