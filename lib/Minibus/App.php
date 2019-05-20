<?php
namespace Minibus;
/**
 *
 */
class App {
    /**
     * @property \Celery\App
     */
    private $app;

    public function indexPage($request, $response) {
        $response->getBody()->write(
            "This is a web service, it should be used from properly configured client code only."
        );
        return $response->withHeader("Content-Type", "text/plain");
    }
    public function __construct() {
        $this->app = new \Celery\App();
        $this->app->get("/", [$this, "indexPage"]);
    }
    public function addService($service) {
        $this->getApp()->group("/{$service->getName()}", function($group_app) use ($service) {
            $service->attach($group_app);
        });
    }
    public function getApp() {
        return $this->app;
    }
    public function run($silent, $server_params = null) {
        $this->getApp()->run($silent, $server_params);
    }
}