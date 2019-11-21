<?php

namespace App\Helpers;

class Fetch
{
  public static function load(string $url, array $customHeaders = null)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Speedrun Questionnaire');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 300);

    if ($customHeaders != null) {
      curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeaders);
    }

    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }
}
