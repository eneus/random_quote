<?php

namespace Drupal\custom_random_quote;

use Drupal\random_quote\RandomQuoteInterface;

/**
 * Class RandomQuoteService.
 */
class StaticRandomQuote implements RandomQuoteInterface {

  /**
   * The Quote array with quote, author and category.
   *
   * @var array
   */
  protected $randomQuote;

  /**
   * Constructs a new RandomQuoteService object.
   *  in this case I had use database random select
   *  if you need get Quotes from static Array for example from content/quotes.json file
   *  you can use native php function file_get_content() and json_decode():
   *
   *  public function __construct() {
   *
   *      $module_path = drupal_get_path('module', 'custom_random_quote');
   *      // parse json file, get content and convert to php array:
   *      $json_quotes = file_get_contents($module_path . '/content/quotes.json');
   *      $quotes = json_decode($json_quotes);
   *      // get one random object quote from Quotes Array
   *      $quote = $quotes[mt_rand(0, count($a) - 1)];
   *
   *      $this->randomQuote = (object) $quote;
   *
   *  }
   *
   */
  public function __construct() {

    $response = \Drupal::database()->select('ffw_quotes', 'ffw')
      ->fields('ffw', array('id', 'category_name', 'author_name', 'quote'))
      ->range(0,1)
      ->orderRandom()
      ->execute()->fetchAssoc();

    $this->randomQuote = (object) $response;

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
