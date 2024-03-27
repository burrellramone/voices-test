<?php
namespace VoicesTest;

//
use Exception;
use Error;
use ErrorException;
use TypeError;

//Voices
use VoicesTest\Controller\Jobs;
use VoicesTest\Controller\Error\NotFound;
use VoicesTest\Exception\NotFound as NotFoundException;
use VoicesTest\Controller\Error\InternalServerError;
use VoicesTest\Exception\ActionNotExist;

final class App {
    private $db;

    public function execute(){
        try {

            $e = null;

            session_start();

            $this->db = Database::getInstance();

            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            // Serve static assets as is
            if (preg_match('@^/assets/?@', $path)) {
                return false;
            }

            $parts = explode("/", $path);
            $parts = array_values(array_filter($parts));
            $action = 'index';
            $notfound_controller = new NotFound();
            
            if(!$parts || $parts[0] == 'jobs'){
                $controller = new Jobs($this->db);
            } else {
                $controller = $notfound_controller;
            }

            if(!($controller instanceof NotFound) && isset($parts[1])) {
                $action = $parts[1];
            }

            $response = $controller->{$action}();;

            $controller->sendHeaders();

            echo $response;

        } catch (Exception $e) {
        } catch (Error $e) {
        } catch (ErrorException $e) {
        } catch (TypeError $e) {
        } finally {
            if($e){
                if(($e instanceof ActionNotExist) || ($e instanceof NotFoundException)){
                    $controller = $notfound_controller;
                } else {
                    $controller = new InternalServerError();
                }

                error_log($e->getMessage());
                $controller->sendHeaders();
                $controller->tmpl->assign("e", $e);
                echo $controller->index();
                exit;
            }
        }

        return true;
    }
}