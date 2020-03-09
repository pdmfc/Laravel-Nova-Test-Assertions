<?php

namespace Pdmfc\NovaTestAssertions\Traits;

use Illuminate\Support\Arr;
use Pdmfc\NovaTestAssertions\Responses\NovaTestResponse;

trait NovaTestAssertions
{
    /**
     * Visit the given resource endpoint.
     *
     * @param string $class
     * @param int $id
     * @return NovaTestResponse
     */
    public function resourceDetail(string $class, int $id): NovaTestResponse
    {
        return new NovaTestResponse($this->get('/nova-api/' . $class::uriKey() . '/' . $id));
    }

    /**
     * Visit the given resource actions endpoint.
     *
     * @param string $class
     * @param int|null $id
     * @return NovaTestResponse
     */
    public function resourceActions($class, $id = null): NovaTestResponse
    {
        $endpoint = '/nova-api/' . $class::uriKey() . '/actions';

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
        $endpoint = '/nova-api/' . $resource::uriKey() . '/action?action=' . (new $action())->uriKey();

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
        $endpoint = '/nova-api/' . $resource::uriKey() . '/count';

        return (new NovaTestResponse($this->get($endpoint)))->original['count'];
    }
}
