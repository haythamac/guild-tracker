<?php

namespace App\Services;

use Egulias\EmailValidator\Warning\TLD;
use thiagoalessio\TesseractOCR\TesseractOCR;

class PowerScreenshotService
{
    public function extractPower($imagePath)
    {
        // Run OCR on the image
        $ocr = new TesseractOCR($imagePath);

        // Configure OCR for digits if the power is just a number
        $ocr->whitelist(range(0, 9));
        $text = $ocr->run();

        // Clean up the text and extract the power value
        return $this->parsePower($text);
    }

    private function parsePower($text)
    {
        // Remove any non-numeric characters
        $cleanText = preg_replace('/[^0-9]/', '', $text);

        // If we have a number, convert it to integer
        if(!empty($cleanText))
        {
            return (int) $cleanText;
        }

        return null;
    }
}