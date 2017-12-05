<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 30/11/17
 * Time: 23:16
 */

namespace Jackal\ImageMerge\Test\UnitTest\Http\Message;

use Jackal\ImageMerge\Http\Message\ImageResponse;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testResponse(){


        $response = new ImageResponse('this is the body',[
            'content-type' => [
                'my-content-type-1'
            ]
        ]);

        //has header
        $this->assertTrue($response->hasHeader('content-type'));
        $this->assertTrue($response->hasHeader('CONTENT-TYPE'));
        $this->assertFalse($response->hasHeader('invalid-header'));

        //getProtocolVersion
        $this->assertEquals("1.1",$response->getProtocolVersion());

        //getStatusCode
        $this->assertEquals(200,$response->getStatusCode());

        //getBody
        $this->assertEquals('this is the body',$response->getBody());

        //getHeaders
        $this->assertEquals(['content-type' => ['my-content-type-1']],$response->getHeaders());

        //getHeader
        $this->assertEquals(['my-content-type-1'],$response->getHeader('content-type'));
        $this->assertEquals([],$response->getHeader('invalid-header'));

        //getHeaderLine
        $this->assertEquals('my-content-type-1',$response->getHeaderLine('content-type'));

        //getReasonPhrase
        $this->assertEquals('OK',$response->getReasonPhrase());

        //withAddedHeader
        $newResponse = $response->withAddedHeader('another-header',['another-header-value']);
        $this->assertEquals('this is the body',$newResponse->getBody());
        $this->assertEquals([
            'content-type' => ['my-content-type-1'],
            'another-header' => ['another-header-value']
        ],$newResponse->getHeaders());

        $this->assertEquals([
            'content-type' => [
                'my-content-type-1',
            ],
        ],$response->getHeaders());

        //withHeader
        $anotherNewResponse = $response->withHeader('content-type',['replace-old-value-1']);
        $this->assertEquals([
            'content-type' => [
                'replace-old-value-1'
            ]
        ],$anotherNewResponse->getHeaders());

        //withoutHeader
        $response = $response->withoutHeader('content-type');
        $this->assertEquals([],$response->getHeaders());

    }
}