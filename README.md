# Laravel Nova Test Assertions
A collection of test assertions and helpers to assist you on testing Laravel Nova applications. 

![Packagist Downloads](https://img.shields.io/packagist/dt/pdmfc/laravel-nova-test-assertions?style=for-the-badge)
![Packagist Version](https://img.shields.io/packagist/v/pdmfc/laravel-nova-test-assertions?label=version&style=for-the-badge)
![Packagist License](https://img.shields.io/packagist/l/pdmfc/laravel-nova-test-assertions?color=blue&style=for-the-badge)

___

## Installation

```bash
composer require pdmfc/laravel-nova-test-assertions --dev
```

Add the `NovaTestAssertions` trait to your tests or to the `TestCase`:

```php
use Pdmfc\NovaTestAssertions\Traits\NovaTestAssertions;

class ExampleTest extends TestCase
{
    use NovaTestAssertions;
}
```

## Test Example

```php
class AssertionsTest extends TestCase
{
    /** @test */
    public function detail_view_has_id_field()
    {
        $this->actingAs($user = factory(User::class)->create());

        $response = $this->resourceDetail(UserResource::class, $user->id);

        $response->assertContainsField(ID::class);
    }

    /** @test */
    public function asserts_total_resources_available_on_index_view(): void
    {
        factory(User::class, 5)->create();

        $actual = $this->resourceCount(UserResource::class);

        $this->assertEquals(6, $actual);
    }

    /** @test */
    public function asserts_run_nova_action(): void
    {
        $user = factory(User::class)->create(['name' => 'Bar']);

        $this->runAction(FooAction::class, UserResource::class, $user->id);

        $this->assertEquals('Foo', $user->fresh()->name);
    }
}
```
