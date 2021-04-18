# behaviour

Rule to indicate the test behavior in its services and stages.

## Installation

Run

```shell
composer require --dev yohanlaborda/behaviour
```

## Configuration

### Manual

Add the **.neon** file to use the rule.

```diff
includes:
+	- vendor/yohanlaborda/behaviour/extension.neon
```

### Parameters

The rule can be configured with various parameters.

```diff
parameters:
+    behaviour:
+        expressions: ["/^.+(Service)$/", "/^.+(Stage)$/"]
+        extensions: ["feature", "features"]
+        maximumIfAllowed: 3
```

### Expressions

You can use the regular expression you want to parse the files. By default the files ending in Name**Service**.php and Name**Stage**.php are searched.

```diff
parameters:
+    behaviour:
+        expressions: ["/^.+(Service)$/", "/^.+(Stage)$/"]
```

### Extensions

To change the extension you must configure the extensions parameter, indicating the desired extensions.

```diff
parameters:
+    behaviour:
+        extensions: ["feature", "features"]
```

### Maximum if allowed

Number of ifs allowed in a method of a class.

```diff
parameters:
+    behaviour:
+        maximumIfAllowed: 3
```

## Usage Behaviour

### `Behaviour(file="filePath")`

```php
<?php

declare(strict_types=1);

class Service
{
    /**
     * @Behaviour("service.feature")
     */
    public function execute(): void
    {
    }
}
```
