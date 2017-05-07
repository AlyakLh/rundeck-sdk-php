<?php

namespace Rundeck\Resources;

use Rundeck\HttpClient;

/**
 * Class Project /api/V/project/
 * @package Rundeck\Resources
 */
class Project
{

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var array
     */
    private $actions = [
        "jobs" => ["xml"],
        "jobs/export" => ["xml"],
        "resources" => ["xml"],
        "executions" => ["xml"],
        "executions/running" => ["xml"],
        "export" => ["xml"],
        "history" => ["xml"],
    ];

    /**
     * @param HttpClient $client
     * @param string $name : Execution ID
     */
    public function __construct(HttpClient $client, $name = null)
    {
        $this->name = $name;
        $this->client = $client;
    }

    /**
     * Get project info
     * @param string $alt xml|json
     * @return array
     */
    public function find($alt = "xml")
    {
        $response = $this->client->get('/project/'.$this->name, $alt);
        return $response;
    }

    /**
     * Find all projects
     * @param string $alt
     * @return array
     */
    public function findAll($alt = "xml")
    {
        $response = $this->client->get('/projects', $alt);
        return $response;
    }

    /**
     * Get Project action
     * @param $action
     * @param string $alt xml|json
     * @return array
     * @throws \Exception
     */
    public function get($action, $alt = "xml")
    {
        if (array_key_exists($action, $this->actions)) {
            if (!in_array($alt, $this->actions[$action])) {
                throw new \Exception("Invalid Format: ". $alt);
            }
            $response = $this->client->get('/project/'.$this->name. '/' .$action, $alt);
            return $response;
        } else {
            throw new \Exception("Action invalid.");
        }
    }

    /**
     * Get project resource
     * @param $name
     * @param string $alt xml|json
     * @return array
     */
    public function resource($name, $alt = "xml")
    {
        $response = $this->client->get('/project/'.$this->name. '/resource/' .$name, $alt);
        return $response;
    }
}