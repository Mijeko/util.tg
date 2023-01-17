<?php

namespace SmallJedi\Core\Api;

use SmallJedi\Core\Json;

class TgBotApi
{
    private $tg_token;

    const TG_URL = 'https://api.telegram.org';
    const ACTION_SEND_MESSAGE = 'sendMessage';
    const ACTION_GET_UPDATES = 'getUpdates';
    const ACTION_SET_WEBHOOK = 'setWebhook';
    const ACTION_REMOVE_WEBHOOK = 'deletewebhook';
    const ACTION_INFO_WEBHOOK = 'getWebhookInfo';
    const ACTION_INFO_WEBHOOKS = 'WebhookInfo';

    public function __construct()
    {
        $this->tg_token = $_ENV['TG_TOKEN'];
    }

    public function sendMessage(string $message, string $target, array $other_params = array())
    {
        return $this->get(self::ACTION_SEND_MESSAGE, array_merge([
            'chat_id' => $target,
            'text' => $message,
        ], $other_params));
    }

    public function getUpdates()
    {
        return $this->get(self::ACTION_GET_UPDATES);
    }

    public function getWebhookInfo($url)
    {
        return $this->get(self::ACTION_INFO_WEBHOOK, [
            'url' => $url,
        ]);
    }

    public function WebhookInfo($url)
    {
        return $this->get(self::ACTION_INFO_WEBHOOKS, [
            'url' => $url,
        ]);
    }

    public function setWebhook($url)
    {
        return $this->get(self::ACTION_SET_WEBHOOK, [
            'url' => $url,
        ]);
    }

    public function deleteWebhook()
    {
        return $this->get(self::ACTION_REMOVE_WEBHOOK);
    }

    public function get(string $method, array $params = array())
    {
        if ($curl = curl_init()) {
            $url = sprintf('%s/bot%s/%s', self::TG_URL, $this->tg_token, $method);

            if ($params) $url = $url . '?' . http_build_query($params);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            $out = curl_exec($curl);
            curl_close($curl);

            $_response = Json::decode($out);

            return $_response;
        }
        return false;
    }

    public function post(string $method, array $params = array())
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, sprintf('%s/bot%s/%s', self::TG_URL, $this->tg_token, $method));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            if ($params) curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            $out = curl_exec($curl);
            curl_close($curl);

            $_response = Json::decode($out);

            return $_response;
        }
        return false;
    }
}