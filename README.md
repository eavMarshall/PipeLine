# PipeLine

Inspired by RxJs pipe.

- Designed to be used with DIContainer (https://github.com/eavMarshall/DiContainer)

```php
$response = $this->getPipeLineInstance()
    ->addPipes(
        SecurityPipable::class,
        RunFunction::class
    )
    ->execute();
```

Makes testing easier by using dependency injection
```php
$this->container = new DIContainer();

$securityMock = $this->getMockBuilder(SecurityPipable::class)->getMock();
$this->container = $this->container->addOverrideRule($securityMock); //set container to return mock

$response = $this->container->getInstanceOf(PipeLine::class)
    ->addPipes(
        SecurityPipable::class, //now mocked out
        RunFunction::class
    )
    ->execute();

self::assertEquals('security checked', $response[SecurityPipable::class]);
self::assertEquals('hello world', $response[RunFunction::class]);
```