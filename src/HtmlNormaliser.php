<?php

namespace App;

class HtmlNormaliser
{
    static function flattenContent($parentClass, $childClass, $content) {
        $document = new \DOMDocument();
        @$document->loadHTML("<main>$content</main>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($document);
        $query = "//*[contains(concat(' ', normalize-space(@class), ' '), ' $parentClass ')]/*[contains(concat(' ', normalize-space(@class), ' '), ' $childClass ')]";
        $childNodes = $xpath->query($query);
        $parentsToProcess = [];
        foreach ($childNodes as $childNode) {
            $parent = $childNode->parentNode;
            if (!in_array($parent, $parentsToProcess, true)) {
                $parentsToProcess[] = $parent;
            }
        }
        foreach ($parentsToProcess as $parent) {
            $tagName = $parent->tagName;
            $className = $parent->getAttribute('class');
            $fragment = $document->createDocumentFragment();
            $children = iterator_to_array($parent->childNodes);
            foreach ($children as $childNode) {
                if ($childNode->nodeType === XML_TEXT_NODE) {
                    $element = $document->createElement($tagName);
                    $element->setAttribute('class', $className);
                    $element->appendChild($document->createTextNode($childNode->nodeValue));
                    $fragment->appendChild($element);
                } else {
                    $fragment->appendChild($childNode->cloneNode(true));
                }
            }
            $parent->parentNode->replaceChild($fragment, $parent);
        }
        $main = $document->getElementsByTagName('main');
        $childNodes = iterator_to_array($main->item(0)->childNodes);
        return implode('', array_map(fn($childNode) => $document->saveHTML($childNode), $childNodes));
    }
}
