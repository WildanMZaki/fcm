<?php

namespace WildanMZaki\Fcm;

class Notification
{
    private static $_token = '';
    private static $_topic = '';
    private $title;
    private $body;
    private $image;
    private $data = [];
    private $pattern = '{data}';
    private $replacer = [];

    public static function to(string $token): self
    {
        self::$_token = $token;
        return new self;
    }

    public static function topic(string $topic): self
    {
        self::$_topic = $topic;
        return new self;
    }

    public function replacePattern($pattern)
    {
        if (strpos($pattern, 'data') === false) throw new \Exception("pattern must contain word 'data'");
        $this->pattern = $pattern;
        return $this;
    }

    public function replace(array $replacer = [])
    {
        $this->replacer = $replacer;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function build(): array
    {
        if (!empty($replacer)) {
            foreach ($this->replacer as $key => $value) {
                $replace = str_replace('data', $key, $this->pattern);
                $this->body = str_replace($replace, $value, $this->body);
                $this->body = str_replace($replace, $value, $this->body);
            }
        }
        $notification = [
            "message" => [
                "notification" => [
                    "title" => $this->title,
                    "body" => $this->body,
                ],
            ]
        ];

        if (!empty($this->image)) {
            $notification["message"]["notification"]["image"] = $this->image;
        }

        if (!empty($this->data)) {
            $notification["message"]["data"] = $this->data;
        }

        if (!empty(self::$_token)) {
            $notification["message"]["token"] = self::$_token;
        }

        if (!empty(self::$_topic)) {
            $notification["message"]["topic"] = self::$_topic;
        }

        return $notification;
    }
}
