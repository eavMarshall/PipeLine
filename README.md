# PipeLine

Inspired by RxJs pipe.

- Designed to be used with DIContainer (https://github.com/eavMarshall/DiContainer)

Pipeline improves the readability, reusability, testing and helps you disconnect your code from the framework you are using.

### Readability
You can easily see the pipeable classes and which order they are executed in.
```php
$response = $this->getPipeLineInstance()
    ->addPipes(
        Pipable1::class,
        Pipable2::class,
        Pipable3::class,
        Pipable4::class,
    )
    ->execute();
```

### Reusability
Pipeable classes from other classes can be added to the pipeline, allowing you to group api calls together

```php
public class MyController()
{
    public function __construct()
    {
        $this->getPipeLineInstance()
            ->addPipes(
                LoginSecurity::class
            );
    }
    
    public function getStaff()
    {
        $response = $this->getPipeLineInstance()
            ->addPipes(
                StaffSecurity::class,
                GetAllStaff::class,
                GetTimetables::class
            )
            ->execute();
        ...
    }
    
    public function getGetService()
    {
        $response = $this->getPipeLineInstance()
            ->addPipes(
                ServiceSecurity::class,
                GetAllService::class
            )
            ->execute();
        ...
    }
    
    public function getStaffAndService()
    {
        $response = $this->getPipeLineInstance()
            ->addPipes(
                StaffSecurity::class,
                ServiceSecurity::class,
                GetAllStaff::class,
                GetTimetables::class,
                GetAllService::class
            )
            ->execute();
        ...
    }
}
```

### Frameworks
By writing your code in the frameworks controller, you are bounding yourself to that framework. You should be able to swap out your logging, memcache or any other feature of a framework with another. At any time.
By binding your company to a framework, you corner your project and potentially leave your company with no option but to do a full re-write.

### Testing
Easily mock away any pipeable class
```php
$this->container = new DIContainer();

$securityMock = $this->getMockBuilder(SecurityPipable::class)->getMock();
$this->container = $this->container->addOverrideRule($securityMock); //set container to return mock

$response = $this->getPipeLineInstance()
    ->addPipes(
        SecurityPipable::class, //now mocked out
        RunFunction::class
    )
    ->execute();

self::assertEquals('security checked', $response[SecurityPipable::class]);
self::assertEquals('hello world', $response[RunFunction::class]);
```