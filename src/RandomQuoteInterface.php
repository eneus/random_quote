<?php

namespace Drupal\random_quote;

/**
 * Interface RandomQuoteInterface.
 */
interface RandomQuoteInterface  {

    /**
     * Gets the Quote.
     *
     * @return string
     *   Quote body.
     */
    public function getQuote();

    /**
     * Gets the Quote Author.
     *
     * @return string
     *   The Quote Author.
     */
    public function getAuthor();

    /**
     * Gets the Quote Category.
     *
     * @return string
     *   The Quote Category.
     */
    public function getCategory();

}
