<?php declare(strict_types = 1);
namespace Templado\Engine;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Templado\Engine\ClearNamespaceDefinitionsFilter
 */
class ClearNamespaceDefinitionFilterTest extends TestCase {
    public function testNamespaceWithoutPrefixGetsReplaced(): void {
        $this->assertEquals(
            '<foo />',
            (new ClearNamespaceDefinitionsFilter())->apply('<foo xmlns="a:ns" />')
        );
    }

    public function testNamespaceForHTMLgetsSet(): void {
        $this->assertEquals(
            '<html xmlns="http://www.w3.org/1999/xhtml" />',
            (new ClearNamespaceDefinitionsFilter())->apply('<html xmlns="a:ns" />')
        );
    }

    public function testRegexErrorsAreTurnedIntoException(): void {
        $this->iniSet('pcre.backtrack_limit', '1');
        $this->expectException(ClearNamespaceDefinitionsFilterException::class);
        (new ClearNamespaceDefinitionsFilter())->apply(\file_get_contents(__DIR__ . '/../_data/filter/regex_backtrack.html'));
    }
}
