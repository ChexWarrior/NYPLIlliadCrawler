<?php

use Chexwarrior\Saver;
use PHPUnit\Framework\TestCase;

class SaverTest extends TestCase
{
    public function removeFinishedRequestsMethodProvider()
    {
        $requests1 = [
            '1' => [
                'title' => 'Fake',
                'status' => 'finished',
            ],
            '2' => [
                'title' => 'Another Fake',
                'status' => 'finished',
            ],
            '3' => [
                'title' => 'Ceezy Bo',
                'status' => 'Under Review For Purchase',
            ]
        ];

        return [
            [$requests1, 1]
        ];
    }

    /**
     * @dataProvider removeFinishedRequestsMethodProvider
     */
    public function testRemoveFinishedRequestsMethod(array $requests, int $expectedAmt)
    {
        $saver = new Saver();
        $filtered = $saver->removeFinishedRequests($requests);

        $this->assertEquals($expectedAmt, count($filtered));
    }
}
