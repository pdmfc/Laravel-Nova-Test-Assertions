<?php

namespace Pdmfc\NovaTestAssertions\Traits;

use Illuminate\Support\Arr;
use Pdmfc\NovaTestAssertions\Responses\NovaTestResponse;

trait NovaTestAssertions
{
    /**
     * @var string
     */
    protected $baseNovaUri = '/nova-api';

    /**
     * Visit the given resource endpoint.
     *
     * @param string $class
     * @param int $id
     * @return NovaTestResponse
     */
    public function resourceDetail(string $class, int $id): NovaTestResponse
    {
        return new NovaTestResponse($this->get($this->resourceUri($class) . '/' . $id));
    }

    /**
     * Visit the given resource actions endpoint.
     *
     * @param string $class
     * @param int|null $id
     * @return NovaTestResponse
     */
    public function resourceActions(string $class, $id = null): NovaTestResponse
    {
        $endpoint = $this->resourceUri($class)  . '/actions';

        if ($id) {
            $endpoint .= '?resourceId=' . $id;
        }

        return new NovaTestResponse($this->get($endpoint));
    }

    /**
     * Executes the given action for the given resource instances.
     *
     * @param string $action
     * @param string $resource
     * @param int|array $id
     * @return NovaTestResponse
     */
    public function runAction(string $action, string $resource, $id): NovaTestResponse
    {
        $endpoint = $this->resourceUri($resource) . '/action?action=' . (new $action())->uriKey();

        return new NovaTestResponse($this->postJson($endpoint, [
            'resources' => implode(',', Arr::wrap($id)),
        ]));
    }

    /**
     * Fetches the total count of available instances for the given resource.
     *
     * @param string $resource
     * @return int
     */
    public function resourceCount(string $resource): int
    {
        $endpoint = $this->resourceUri($resource)  . '/count';

        return (new NovaTestResponse($this->get($endpoint)))->original['count'];
    }

    /**
     * The Nova Resource base URI.
     *
     * @param $resource
     * @return string
     */
    protected function resourceUri($resource): string
    {
        return $this->baseNovaUri . '/' . $resource::uriKey();
    }
}
