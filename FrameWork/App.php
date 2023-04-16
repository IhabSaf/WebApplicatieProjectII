<?php
namespace FrameWork;

use FrameWork\Database\EntityManagerInterface;
use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\Interface\RequestInterface;
use FrameWork\Interface\ResponseInterface;
use FrameWork\Route\Redirect;
use FrameWork\Route\Route;
use FrameWork\Route\RouteInterface;
use FrameWork\security\AccessController;
use FrameWork\security\AccessControllerInterFace;

class App
{
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [], session: [], attributes: [])] private RequestInterface $request,
        #[Service(Route::class), Argument(routes: [], routeObjectClass: "FrameWork\Route\RouteObject")] private RouteInterface $route,
        private Template $template,
        #[Service(AccessController::class)] private AccessControllerInterFace $accessController,
        #[Service(EntityManger::class)] private EntityManagerInterface $entityManger,
        private Redirect $redirect,
        private DiContainer $diContainer){}

    public function handle(): ResponseInterface
    {
        $array = [];
        $path = $this->request->getPathInfo();
        if ($path === '/') {
            $this->redirect->toUrl('/home');
        }

        if ($this->request->getServerByName('REQUEST_METHOD') === 'POST') {
            $array += $this->request->getPostSecure();
        }
        if ($this->route->isValidRoute($path)) {
            $routeObject = $this->route->getRoute($path);
            if ($routeObject->hasParams()) {
                $routeObject->setUrlParamsWithoutDefault($path);
                $this->request->addAttributes($routeObject->getUrlParams());
            }
            // Check  de accessController
            $controller = $routeObject->getController();
            $method = $routeObject->getMethod();
            $userRole = $this->request->getSessionValueByName('user_role') ?? 'gast';

            //roep de AccessController functie, dit geeft boolean terug en kijk of de huidige user mag naar de gevraagde controller.
            $hasAccess = $this->accessController->checkAccess($userRole, $controller, $method);
            if (!$hasAccess) {
                $response = $this->template->renderSimple("Access denied." ,403);
            } else {
                $controller = $this->diContainer->createClass($controller);
                $array += $controller->{$method}($this->request);
                $response = $this->template->renderPage($this->request, $routeObject, $array);
            }

        } else {
            $response = $this->template->renderSimple("Deze pagina bestaat niet.", 404);
        }
        return $response;
    }
}