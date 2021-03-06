<?php

namespace BonderTest\Filters;

/**
 * @author hbandura
 */
final class ConfiguredFiltersProviderTest extends \PHPUnit_Framework_TestCase {
  
  public function testSimple() {
    $uri = '/boring_uri/nthaoesu/aoeusthaosetu/uaoeu';
    $originalFilters = array(
      $this->getMock("\Bonder\Filter"),
      $this->getMock("\Bonder\Filter"),
      $this->getMock("\Bonder\Filter"),
      $this->getMock("\Bonder\Filter")
    );
    $configurator = $this->getMock("\Bonder\Util\Configurator");
    $configured = array();
    $configurator->expects($this->any())->method("configure")
      ->with($this->callback(function(\Bonder\Filter $filter) use (&$configured) {
      $configured[] = $filter;
      return true;
    }))->will($this->returnArgument(0));
    $wrappedProvider = $this->getMock("\Bonder\Filters\FiltersProvider");
    $wrappedProvider->expects($this->any())->method("getFilters")
      ->with($uri)->willReturn($originalFilters);
    $fp = new \Bonder\Filters\ConfiguredFiltersProvider(
      $wrappedProvider, $configurator);
    $filters = $fp->getFilters($uri);
    $this->assertEquals($originalFilters, $configured);
    $this->assertEquals($originalFilters, $filters);
  }
  
}