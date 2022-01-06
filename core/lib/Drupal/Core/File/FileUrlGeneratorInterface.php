<?php

namespace Drupal\Core\File;

use Drupal\Core\Url;

/**
 * Generates file URLs for a stream to an external or local file.
 *
 * Compatibility: normal paths and stream wrappers.
 *
 * There are two kinds of local files:
 * - "managed files", i.e. those stored by a Drupal-compatible stream wrapper.
 *   These are files that have either been uploaded by users or were generated
 *   automatically (for example through CSS aggregation).
 * - "shipped files", i.e. those outside of the files directory, which ship as
 *   part of Drupal core or contributed modules or themes.
 *
 * Separate methods are provided to provide absolute and relative URLs as well
 * as plain strings or Url objects, depending on the requirements. In general,
 * it is recommended to always use relative URLs unless absolute URL's are
 * required.
 */
interface FileUrlGeneratorInterface {

  /**
   * Creates a root-relative web-accessible URL string.
   *
   * @param string $uri
   *   The URI to a file for which we need an external URL, or the path to a
   *   shipped file.
   *
   * @return string
   *   For a local URL (matching domain), a root-relative string containing a
   *   URL that may be used to access the file. An absolute URL may be returned
   *   when using a CDN or a remote stream wrapper.
   *
   * @throws \Drupal\Core\File\Exception\InvalidStreamWrapperException
   *   If a stream wrapper could not be found to generate an external URL.
   */
  public function generateString(string $uri): string;

  /**
   * Creates an absolute web-accessible URL string.
   *
   * @param string $uri
   *   The URI to a file for which we need an external URL, or the path to a
   *   shipped file.
   *
   * @return string
   *   An absolute string containing a URL that may be used to access the
   *   file.
   *
   * @throws \Drupal\Core\File\Exception\InvalidStreamWrapperException
   *   If a stream wrapper could not be found to generate an external URL.
   */
  public function generateAbsoluteString(string $uri): string;

  /**
   * Creates a root-relative web-accessible URL object.
   *
   * @param string $uri
   *   The URI to a file for which we need an external URL, or the path to a
   *   shipped file.
   *
   * @return \Drupal\Core\Url
   *   For a local URL (matching domain), a base-relative Url object containing
   *   a URL that may be used to access the file. An Url object with absolute
   *   URL may be returned when using a CDN or a remote stream wrapper. Use
   *   setAbsolute() on the Url object to build an absolute URL.
   *
   * @throws \Drupal\Core\File\Exception\InvalidStreamWrapperException
   *   If a stream wrapper could not be found to generate an external URL.
   */
  public function generate(string $uri): Url;

  /**
   * Transforms an absolute URL of a local file to a relative URL.
   *
   * May be useful to prevent problems on multisite set-ups and prevent mixed
   * content errors when using HTTPS + HTTP.
   *
   * @param string $file_url
   *   A file URL of a local file as generated by
   *   \Drupal\Core\File\FileUrlGenerator::generate().
   * @param bool $root_relative
   *   (optional) TRUE if the URL should be relative to the root path or FALSE
   *   if relative to the Drupal base path.
   *
   * @return string
   *   If the file URL indeed pointed to a local file and was indeed absolute,
   *   then the transformed, relative URL to the local file. Otherwise: the
   *   original value of $file_url.
   */
  public function transformRelative(string $file_url, bool $root_relative = TRUE): string;

}