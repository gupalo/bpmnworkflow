BpmnWorkflow Bundle
===================

## Install

```bash
composer require gupalo/bpmnworkflow-bundle
```

## Example

Register extension
```php
    $walker = new ProcessWalker(new ExtensionHandler([
        new DiscountProcedure(),
        new WithoutDiscountProcedure(),
        new PriceFunction(),
        new LocaleFunction(),
        new EqValueComparison(),
        new LessValueComparison(),
        new MoreValueComparison(),
    ]));
```

Loader bpmn
```php
    $loader = (new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')
```

Context
```php
    $cart = new Example\Cart\Cart(
        items: ['name' => 'cola', 'price' => 800],
        locale: 'en',
        price: 800,
    );
    $context = new DataContext($cart);
```

Walker
```php
    $workflow = new Workflow($loader, $walker);
    $this->workflow->walk('cart_discount', $context);
```

## Test

```bash
php bin/phpunit vendor/gupalo/bpmnworkflow
```
