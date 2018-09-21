<?php

namespace Drupal\random_quote\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\random_quote\RandomQuoteInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Random Quote' block.
 *
 * @Block(
 *   id = "random_quote_block",
 *   admin_label = @Translation("Random Quote"),
 *   category = @Translation("FFW")
 * )
 */
class RandomQuoteBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The quote service.
   *
   * @var \Drupal\random_quote\RandomQuoteService
   */
  protected $randomQuote;

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('random_quote')
    );
  }

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\random_quote\RandomQuoteInterface $randomQuote
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RandomQuoteInterface $randomQuote) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->randomQuote = $randomQuote;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => '<i>'.$this->randomQuote->getCategory() . ':</i> ' . $this->randomQuote->getQuote().'<br> - <b>' . $this->randomQuote->getAuthor().'</b>'
    ];
    $build['#cache']['max-age'] = 0;
    return $build;
  }

}
