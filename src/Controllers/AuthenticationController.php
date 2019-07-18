<?php
/**
 * Date: 18.07.19
 */

namespace src\Controllers;


use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class AuthenticationController
{
    /**
     * @var Twig
     */
    private $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function login(Request $request, Response $response, $next): Response
    {
        var_dump($request->getAttribute('error'));

        return $this->view->render($response, 'login.html.twig');
    }

}
