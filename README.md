BpmnWorkflow
===================

## Install

```bash
composer require gupalo/bpmnworkflow
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

For test in main app need install require-dev dependency

```bash
composer require phpunit/phpunit --dev
```

Add to composer.json autoload-dev section

```json
"autoload-dev": {
    "psr-4": {
        "Gupalo\\BpmnWorkflow\\Tests\\": "vendor/gupalo/bpmnworkflow/tests/"
    }
}
```

Execute

```bash
composer dump-autoload
php vendor/bin/phpunit vendor/gupalo/bpmnworkflow
```

