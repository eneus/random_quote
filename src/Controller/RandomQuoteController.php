<?php

namespace Drupal\random_quote\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\random_quote\RandomQuoteInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Random Quote routes.
 */
class RandomQuoteController extends ControllerBase {

  /**
   * The quote service.
   *
   * @var \Drupal\random_quote\RandomQuoteService
   */
  protected $randomQuote;

  /**
   * Constructs the controller object.
   *
   * @param \Drupal\random_quote\RandomQuoteInterface $randomQuote
   *   The quote service.
   */
  public function __construct(RandomQuoteInterface $randomQuote) {
    $this->randomQuote = $randomQuote;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $randomQuote = $container->get('random_quote')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->randomQuote->getQuote()
    ];

    return $build;
  }

}
