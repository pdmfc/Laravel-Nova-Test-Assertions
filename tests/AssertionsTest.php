<?php

namespace Pdmfc\NovaTestAssertions\Tests;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Pdmfc\NovaTestAssertions\Tests\Fixtures\User;
use Pdmfc\NovaTestAssertions\Tests\Fixtures\FooAction;
use Pdmfc\NovaTestAssertions\Tests\Fixtures\UserResource;

class AssertionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(factory(User::class)->create());
    }

    /** @test */
    public function asserts_detail_view_contains_a_given_field_class(): void
    {
        $response = $this->resourceDetail(UserResource::class, 1);

        $response->assertContainsField(ID::class);
    }

    /** @test */
    public function asserts_detail_view_contains_multiple_fields(): void
    {
        $response = $this->resourceDetail(UserResource::class, 1);

        $response->assertContainsFields([ID::class, Text::class]);
    }

    /** @test */
    public function asserts_resources_have_action(): void
    {
        $response = $this->resourceActions(UserResource::class);

        $response->assertContainsAction(FooAction::class);
    }

    /** @test */
    public function asserts_a_given_resource_has_action(): void
    {
        $response = $this->resourceActions(UserResource::class, 1);

        $response->assertContainsAction(FooAction::class);
    }

    /** @test */
    public function asserts_run_nova_action(): void
    {
        $user = factory(User::class)->create(['name' => 'Bar']);

        $this->runAction(FooAction::class, UserResource::class, $user->id);

        self::assertEquals('Foo', $user->fresh()->name);
    }

    /** @test */
    public function asserts_total_resources_available_on_index_view(): void
    {
        factory(User::class, 5)->create();

        $actual = $this->resourceCount(UserResource::class);

        self::assertEquals(6, $actual);
    }
}
