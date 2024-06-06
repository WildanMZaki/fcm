# WildanMZaki FCM Package

This package provides an easy way to send Firebase Cloud Messaging (FCM) notifications using Guzzle HTTP client.

## Installation

First, install the package via Composer:

```bash
composer require wildanmzaki/fcm
```

## Usage

### Initialization

You need to provide the path to your Firebase service account credentials file and the project ID to initialize the `Client`.

```php
use WildanMZaki\Fcm\Client;
use WildanMZaki\Fcm\Notification;

// Path to your Firebase service account credentials
$credentialsFilePath = storage_path('service-account.json');
$projectId = 'your-firebase-project-id';

// Initialize the client
$client = new Client($credentialsFilePath, $projectId);
```

### Sending a Notification to a Specific Device

You can send a notification to a specific device by providing the device token.

```php
// Create a notification
$notification = Notification::to('device-token')
    ->setTitle('Notification Title')
    ->setBody('Notification Body')
    ->setImage('https://example.com/image.png')
    ->setData(['key' => 'value']);

// Send the notification
$response = $client->send($notification);

// Print the response
print_r($response);
```

### Sending a Notification to a Topic

You can send a notification to a topic by providing the topic name.

```php
// Create a notification
$notification = Notification::topic('your-topic')
    ->setTitle('Notification Title')
    ->setBody('Notification Body')
    ->setImage('https://example.com/image.png')
    ->setData(['key' => 'value']);

// Send the notification
$response = $client->send($notification);

// Print the response
print_r($response);
```

## Classes

### `WildanMZaki\Fcm\Client`

The `Client` class is responsible for sending notifications to the FCM API.

#### `__construct(string $credentialsFilePath, string $projectId, bool $isProduction = false)`

- `$credentialsFilePath` - Path to the Firebase service account credentials file.
- `$projectId` - Your Firebase project ID.
- `$isProduction` - (Optional) If `true`, the client will be initialized for production use.

#### `send(Notification $notification)`

- `notification` - An instance of the `Notification` class.
- Returns the response from the FCM API.

### `WildanMZaki\Fcm\Notification`

The `Notification` class is used to build the notification payload.

#### `static to(string $token): self`

- `$token` - The device token to which the notification will be sent.
- Returns an instance of the `Notification` class.

#### `static topic(string $topic): self`

- `$topic` - The topic to which the notification will be sent.
- Returns an instance of the `Notification` class.

#### `setTitle(string $title): self`

- `$title` - The title of the notification.
- Returns the current instance of the `Notification` class.

#### `setBody(string $body): self`

- `$body` - The body of the notification.
- Returns the current instance of the `Notification` class.

#### `setImage(string $image): self`

- `$image` - The URL of the image to be included in the notification.
- Returns the current instance of the `Notification` class.

#### `setData(array $data): self`

- `$data` - An associative array of additional data to be included in the notification.
- Returns the current instance of the `Notification` class.

#### `build(): array`

- Builds the notification payload.
- Returns the notification payload as an array.

## License

This package is open-sourced software licensed under the MIT license.

```

```
