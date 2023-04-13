<?php
namespace FrameWork;

use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;
use FrameWork\Route\Route;
use FrameWork\security\AccessController;

class App
{
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [])] private IRequest $request,
        private Route $route, private Template $template){}

    public function handle(): IResponse
    {
        session_start();
        $array = [];
        $path = $this->request->getPathInfo();
        if ($this->request->getServerByName('REQUEST_METHOD') === 'POST') {
            $array += $this->request->getPostSecure();
        }
        if ($this->route->isValidRoute($path)) {
            $routeObject = $this->route->getRoute($path);
            // Check  de accessController
            $checkController = $routeObject->getController();
            $checkMethod = $routeObject->getMethod();
            $userRole = $_SESSION['user_rol'] ?? 'gast';

            //roep de AccessController functie, dit geeft boolean tuerg en kijk of de huidige user mag naar de gevraagde controller.
            $hasAccess = AccessController::checkAccess($userRole, $checkController, $checkMethod);
            if (!$hasAccess) {
                $response = $this->template->renderSimple("Access denied." ,403);
            }
            else{
                $array += $routeObject->controller($this->request);
                $response = $this->template->renderPage($routeObject, $array);
            }

        } else {
            $response = $this->template->renderSimple("Deze pagina bestaat niet.", 404);
        }
        return $response;
    }
}