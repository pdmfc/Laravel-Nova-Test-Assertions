<?php

namespace Pdmfc\NovaTestAssertions\Responses;

use Illuminate\Testing\Assert;
use Illuminate\Testing\TestResponse;

class NovaTestResponse extends TestResponse
{
    /**
     * Validates that a field is available.
     *
     * @param string $expected
     */
    public function assertContainsField(string $expected): void
    {
        $actual = $this->getFieldsClasses();

        Assert::assertContains($expected, $actual);
    }

    /**
     * Validates that a set of fields are available.
     *
     * @param array $expected
     */
    public function assertContainsFields(array $expected): void
    {
        $actual = $this->getFieldsClasses();

        Assert::assertArraySubset($expected, $actual);
    }

    /**
     * Validates that an action is available.
     *
     * @param string $expected
     */
    public function assertContainsAction(string $expected): void
    {
        $actual = $this->getActionsClasses();

        Assert::assertContains($expected, $actual);
    }

    /**
     * Returns the classname of all fields available.
     *
     * @return array
     */
    public function getFieldsClasses(): array
    {
        return collect($this->original['resource']['fields'])
            ->map(static function ($field) {
                return get_class($field);
            })->toArray();
    }

    /**
     * Returns the classname of all actions available.
     *
     * @return array
     */
    public function getActionsClasses(): array
    {
        return collect($this->original['actions'])
            ->map(static function ($action) {
                return get_class($action);
            })->toArray();
    }
}
