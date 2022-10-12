<?php

namespace Perspective\OptionalEmail\Model;

class XmlBacktracer
{

    public static function create(): string
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

    public static function evaluateXpath(?string $xml, string $xpath): bool
    {
        if (!$xml) {
            $xml = self::create();
        }

        $document = simplexml_load_string($xml);
        $elements = $document->xpath($xpath);
        return count($elements) > 0;
    }
}
