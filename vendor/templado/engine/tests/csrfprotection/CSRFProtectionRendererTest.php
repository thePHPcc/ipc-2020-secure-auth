<?php declare(strict_types = 1);
namespace Templado\Engine;

use DOMDocument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Templado\Engine\CSRFProtectionRenderer
 */
class CSRFProtectionRendererTest extends TestCase {

    /** @var CSRFProtection */
    private $protection;

    /** @var CSRFProtectionRenderer */
    private $renderer;

    /** @var DOMDocument */
    private $expected;

    protected function setUp(): void {
        $protection = $this->createMock(CSRFProtection::class);
        $protection->method('getFieldName')->willReturn('csrf');
        $protection->method('getTokenValue')->willReturn('secure');

        $this->protection = $protection;
        $this->renderer   = new CSRFProtectionRenderer();

        $this->expected = new DOMDocument();
        $this->expected->loadXML(
            '<?xml version="1.0"?>
            <html><body><form><input type="hidden" name="csrf" value="secure"/></form></body></html>'
        );
    }

    public function testCSRFTokenFieldGetsAddedWhenMissing(): void {
        $dom = new DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><html><body><form></form></body></html>');

        $this->renderer->render($dom->documentElement, $this->protection);

        $this->assertEqualXMLStructure(
            $this->expected->documentElement,
            $dom->documentElement
        );
    }

    public function testCSRFTokenFieldGetsUpdatedWithTokenValue(): void {
        $dom = new DOMDocument();
        $dom->loadXML(
            '<?xml version="1.0"?>
            <html><body><form><input type="hidden" name="csrf" value=""/></form></body></html>'
        );

        $this->renderer->render($dom->documentElement, $this->protection);

        $this->assertEqualXMLStructure(
            $this->expected->documentElement,
            $dom->documentElement
        );

        $input = $dom->getElementsByTagName('input')->item(0);
        $this->assertEquals('secure', $input->getAttribute('value'));
    }

    public function testCSRFTokenFieldGetsAddedWithCorrectNamespaceWhenMissing(): void {
        $dom = new DOMDocument();
        $dom->loadXML('<?xml version="1.0" ?><html xmlns="a:b"><body><form></form></body></html>');

        $this->renderer->render($dom->documentElement, $this->protection);

        $this->assertEqualXMLStructure(
            $this->expected->documentElement,
            $dom->documentElement
        );

        $input = $dom->getElementsByTagName('input')->item(0);
        $this->assertEquals('a:b', $input->namespaceURI);
        $this->assertEquals('secure', $input->getAttribute('value'));
    }


    public function testCSRFTokenFieldWithNamespaceGetsUpdatedWithTokenValue(): void {
        $dom = new DOMDocument();
        $dom->loadXML(
            '<?xml version="1.0"?>
            <html xmlns="a:b"><body><form><input type="hidden" name="csrf" value=""/></form></body></html>'
        );

        $this->renderer->render($dom->documentElement, $this->protection);

        $this->assertEqualXMLStructure(
            $this->expected->documentElement,
            $dom->documentElement
        );

        $input = $dom->getElementsByTagName('input')->item(0);
        $this->assertEquals('secure', $input->getAttribute('value'));
    }

}
