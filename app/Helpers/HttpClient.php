<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class HttpClient
{
  private $client;
  private $custom_headers;

  public function __construct()
  {
    if (app()->environment(['local'])) {
      $this->client = new Client(['base_uri' => config('api.dev')]);
    }

    if (app()->environment(['staging'])) {
      $this->client = new Client(['base_uri' => config('api.staging')]);
    }

    if (app()->environment(['production'])) {
      $this->client = new Client(['base_uri' => config('api.prod')]);
    }
  }

  public function post(string $path, $data = [])
  {
    try {
      $response = $this->client->post($path, [
        'headers' => $this->custom_headers ?? $this->headers(),
        'json' => $data,
        'timeout' => 60
      ]);

      $body = json_decode($response->getBody());
      if (!empty($body)) {
        // 
      }

      return $body;
    } catch (RequestException $e) {
      logger()->error($e);
      throw $e;
    }
  }

  public function get(string $path)
  {
    try {
      $response = $this->client->get($path, [
        'headers' => $this->headers() ?? $this->headers(),
        'timeout' => 30
      ]);
      
      $body = json_decode($response->getBody());

      if (!empty($body)) {
        //
      }

      return $body;
    } catch (RequestException $e) {
      logger()->error($e);

      throw $e;
    } 
  }

  private function headers()
  {
    return [
        'Content-Type' => 'application/json',
        'X-Content-Type-Options'=>'nosniff',
        'X-XSS-Protection'=> '1; mode=block',
        'Strict-Transport-Security'=> 'max-age=31536000; includeSubDomains; preload',
        'X-Frame-Options'=>'SAMEORIGIN',
        'APIKey' => '1234567890'
    ];
  }

  public function withCustomUri(string $uri)
  {
    $this->client = new Client(['base_uri' => $uri]);
    return $this;
  }
  public function withCustomHeaders(array $headers)
  {
    $this->custom_headers = $headers;
    return $this;
  }
}
