<?php

namespace Perspective\OptionalEmail\Model;

use DiDom\Document;

class XmlBacktrace
{

    /**
     * @var Document
     */
    private $document;

    /**
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function create(): string
    {
        $nodeXml = "<call file=\"__FILE__\">__INNER__</call>";

        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        $calls = array_values(array_filter($backtrace, static function (array $data) {
            return array_key_exists('file', $data)
                && mb_strstr($data['file'], 'Perspective/OptionalEmail') === false
                && mb_strstr($data['file'], 'perspective/module-optional-email') === false
                && mb_strstr($data['file'], 'Interceptor.php') === false
                && mb_strstr($data['file'], 'Interceptor::__callPlugins') === false
                && mb_strstr($data['file'], 'Magento/Eav') === false;
        }));

        $result = "";
        for ($i = count($calls) - 1; $i >= 0; $i--) {
            $currentNodeXml = str_replace("__FILE__", $calls[$i]['file'], $nodeXml);
            $result = str_replace("__INNER__", $result, $currentNodeXml);
        }

        return "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\" ?>" . $result;
    }

    public function evaluateXpath(?string $xml, string $xpath): bool
    {
        if (!$xml) {
            $xml = $this->create();
        }

        $this->document->loadXml($xml);
        $elements = $this->document->xpath($xpath);
        return count($elements) === 1 && $elements[0]->outerHtml() === $this->document->xpath('/call')[0]->outerHtml();
    }
}
