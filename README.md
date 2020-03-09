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
}
```
