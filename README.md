# PipeLine

Inspired by RxJs pipe.

- Designed to be used with DIContainer (https://github.com/eavMarshall/DiContainer)

```php
$response = $this->getPipeLineInstance()
    ->pipe(
        SecurityPipe::class,
        RunFunction::class
    );
```

Makes testing easier by using dependency injection
```php
$this->container = new DIContainer();

$securityMock = $this->getMockBuilder(SecurityPipe::class)->getMock();
$this->container = $this->container->addOverrideRule($securityMock); //set container to return mock

$response = $this->container->getInstanceOf(PipeLine::class)
    ->pipe(
        SecurityPipe::class, //now mocked out
        RunFunction::class
    );

self::assertEquals('security checked', $response[SecurityPipe::class]);
self::assertEquals('hello world', $response[RunFunction::class]);
```