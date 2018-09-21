<?php

namespace Drupal\random_quote;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class RandomQuoteService.
 */
class RandomQuoteService implements RandomQuoteInterface {

  /**
  * The Quote array with quote, author and category.
  *
  * @var array
  */
  protected $randomQuote;

  /**
   * {@inheritdoc}
   *
   * Constructs a new RandomQuoteService object with
   * quotes, authors and category.
   *
   * param \GuzzleHttp\Client $http_client
   *   The Guzzle HTTP Client.
   */
  public function __construct(Client $http_client) {

    $requestParameters = $this->getRequestParameters();

    try {
      $request = $http_client->request($requestParameters['method'], $requestParameters['url'], $requestParameters['header']);
    }
    catch (RequestException $e) {
      watchdog_exception('AdvAgg Validator', $e);
    }
    catch (\Exception $e) {
      watchdog_exception('AdvAgg Validator', $e);
    }
    if (!empty($request)) {
      $response = json_decode($request->getBody());
      $this->randomQuote = $response[0];
    }

    return ['error' => t('W3C Server did not return a 200 or request data was empty.')];
  }

  /**
   * Gets the Request Parameters.
   *
   * @return array
   *   Quote Request Parameters.
   */
  public function getRequestParameters() {

    //Get Quotes API configurations
    $config = \Drupal::config('random_quote.settings');

    return [
      'method' => 'GET',
      'url' => $config->get('url'),
      'header' => array(
        'headers' => [
          'Accept' => 'application/json',
          'Content-Type' => 'application/json',
          'X-Mashape-Key' => $config->get('api_key')
        ]
      )
    ];
  }

  /**
   * Gets the Quote.
   *
   * @return string
   *   Quote body.
   */
  public function getQuote() {
    return $this->randomQuote->quote;
  }

  /**
   * Gets the Quote Author.
   *
   * @return string
   *   The Quote Author.
   */
  public function getAuthor() {
    return $this->randomQuote->author_name;
  }

  /**
   * Gets the Quote Category.
   *
   * @return string
   *   The Quote Category.
   */
  public function getCategory() {
    return $this->randomQuote->category_name;
  }

}
