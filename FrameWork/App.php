<?php
namespace FrameWork;

use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\RequestInterface;
use FrameWork\Interface\ResponseInterface;
use FrameWork\Route\Redirect;
use FrameWork\Route\Route;
use FrameWork\security\AccessController;

class App
{
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [], session: [], attributes: [])] private RequestInterface $request,
        private Route $route,
        private Template $template,
        private AccessController $accessController,
        private EntityManger $entityManger,
        private Redirect $redirect){}

    public function handle(): ResponseInterface
    {
        $array = [];
        $path = $this->request->getPathInfo();
        if($path === '/'){
            $this->redirect->toUrl('/home');
        }

        if ($this->request->getServerByName('REQUEST_METHOD') === 'POST') {
            $array += $this->request->getPostSecure();
        }
        if ($this->route->isValidRoute($path)) {
            $routeObject = $this->route->getRoute($path);
            // Check  de accessController
            $checkController = $routeObject->getController();
            $checkMethod = $routeObject->getMethod();
            $userRole = $this->request->getSessionValueByName('user_role') ?? 'gast';

            //roep de AccessController functie, dit geeft boolean tuerg en kijk of de huidige user mag naar de gevraagde controller.
            $hasAccess = $this->accessController->checkAccess($userRole, $checkController, $checkMethod);
            if (!$hasAccess) {
                $response = $this->template->renderSimple("Access denied." ,403);
            }
            else{
                $array += $routeObject->controller($this->request, $this->entityManger);
                $response = $this->template->renderPage($this->request, $routeObject, $array);
            }

        } else {
            $response = $this->template->renderSimple("Deze pagina bestaat niet.", 404);
        }
        return $response;
    }
}