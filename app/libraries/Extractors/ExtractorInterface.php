<?php
namespace Extractors;

interface ExtractorInterface
{
    public function getDomElement($html);

    public function getTitle($domHtml);

    public function getIngredients($domHtml);

    public function getYield($domHtml);

    public function getPreparations($domHtml);

    public function extract($html);
}
