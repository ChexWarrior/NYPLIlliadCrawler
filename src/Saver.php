<?php

namespace Chexwarrior;

/**
 * Responsible for creating, updating and saving outstanding requests file
 *
 * @package Chexwarrior
 */
class Saver
{
    public function loadFile(string $filePath): array
    {
        $fileContents = file_get_contents($filePath);

        return json_decode($fileContents);
    }

    public function saveFile(string $filePath, array $newContents): void
    {
        $jsonContent = json_encode($newContents);

        file_put_contents($filePath, $jsonContent);
    }

    public function updateRequests(array $newRequests, array $savedRequests): array
    {

        // Remove any contents that in in $savedRequests and not in $newRequests

        // Add any contents that are in $newRequests and not in $savedRequests

        // Update any contents in $savedRequests that are in $newRequests

    }
}
