<?php

namespace Chexwarrior;

/**
 * Responsible for saving and loading save file of outstanding requests
 * Responsible for determining which outstanding requests have changed
 *
 * @package Chexwarrior
 */
class Saver
{
    public function loadFile(string $filePath)
    {
        $fileContents = file_get_contents($filePath);

        return json_decode($fileContents, true);
    }

    public function saveFile(string $filePath, array $newContents): void
    {
        $jsonContent = json_encode($newContents);

        file_put_contents($filePath, $jsonContent);
    }

    /**
     * Determines which requests have changed and should send a notification
     *
     * @param array $newRequests
     * @param array $savedRequests
     * @return array
     */
    public function determineChangedRequests(array $newRequests, array $savedRequests): array
    {
        $changedRequests = [];
        foreach ($newRequests as $request) {
            $transactionId = array_key_first($request);
            ['status' => $status, 'title' => $title] = $request;

            // Check if we already have a record of this transaction
            if (key_exists($transactionId, $savedRequests)) {
                $savedRequest = $savedRequests[$transactionId];
                ['status' => $savedStatus] = $savedRequest;

                // Notify if status changed
                if ($savedStatus !== $status) {
                    $changedRequests[] = $request;
                }

            // Notify about any records not in $savedRequests
            } else {
                $request['status'] = 'new';
                $changedRequests[] = $request;
            }
        }

        /**
         * Check for requests in $savedRequests not in $newRequests,
         * this indicates requests that have finished
         */
        $finishedRequests = array_diff($savedRequests, $newRequests);
        array_walk($finishedRequests, fn(array &$i) => $i['status'] = 'finished');
        $changedRequests += $finishedRequests;

        return $changedRequests;
    }

    /**
     * Removes requests with status finished
     *
     * @param array $requests
     * @return void
     */
    public function removeFinishedRequests(array $requests)
    {
        return array_filter($requests, fn($r) => $r['status'] !== 'finished');
    }
}
