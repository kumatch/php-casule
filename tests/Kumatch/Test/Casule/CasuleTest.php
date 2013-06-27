<?php

namespace Kumatch\Test\Casule;

use Kumatch\Casule\Casule;

class CasuleTest extends \PHPUnit_Framework_TestCase
{
    protected $skelton;

    protected $salt = "testsalt";

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function noSaltProvider()
    {
        return array(
            array('+9sdGxiqbAgyS31ktx+3Y3BpDh0=', null),
            array('E8YJX8OYfWifXiYrGlQAAkWTTBI=', array('foo' => 123)),
            array('0m5RNhcVh3ytHmpR3b5Xy5Lx/BI=', array('foo' => 123, 'bar' => 4567, 'baz' => 'quuux'))
        );
    }

    public function withSaltProvider()
    {
        return array(
            array('Ys26uXfhUJe/aisbjLJcUZLh4PI=', null),
            array('/oVk84cImgdzooNmrOCFcLg3Zvc=', array('foo' => 123)),
            array('OuZjni652p9rWm4FA8qebPQUK3U=', array('foo' => 123, 'bar' => 4567, 'baz' => 'quuux'))
        );
    }

    public function sha512NoSaltProvider()
    {
        return array(
            array('uTbO6Gyfh6pdPG8uhMtaQjml/lBICm7Ga3CrWx9KxnMMbFFUIbMn7B1pQC5T37Sa1zgesGezOP17DLIiRyJdRw==', null),
            array('f0csIMFELbFXQxklKsNx+cRxOvDF6tBKESTPVAy2soEyoosD9tLtbYddh5b67FNZ8JHSgvuq36Nm0ak4g9/zVg==', array('foo' => 123)),
            array('uIQJydzJx8z974K2KjMk3h7vIL4jSz4XixrUUw4At0aLLvnI3zrKrdb6pJpo5nsX7wQV44OeoTzgDey2qMF+pw==', array('foo' => 123, 'bar' => 4567, 'baz' => 'quuux'))
        );
    }

    public function sha512WithSaltProvider()
    {
        return array(
            array('f/30Kud3L/T2pgmESc6ZkRPRaqReBLf8W4NfzIeiKsIrRW2sWTX8geDk+8lFVIlqEhqM3TfjCoPxI2NiREG8cQ==', null),
            array('f6UDOuwJXLuOAMyA9E07RsYTXvXMilZeKHhjtphkYGEyO9YmuCmfo8Co/nSMem3PHq6RO/cu2rlf1OiQHpPZZw==', array('foo' => 123)),
            array('gVENar7OZhCqlPMRRn73H7/XRNw6bIfhIbWxtUgeAihxV+BRlJYcQnUpsbm4YQJqvO5ePj6rBDKWfeLLqPbSQg==', array('foo' => 123, 'bar' => 4567, 'baz' => 'quuux'))
        );
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider noSaltProvider
     */
    public function testSaltなしでチャレンジトークンを作成する($token, $attributes)
    {
        $casule = new Casule();

        $this->assertEquals($token, $casule->create($attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider noSaltProvider
     */
    public function testSaltなしでチャレンジトークンの妥当性を確認する($token, $attributes)
    {
        $casule = new Casule();

        $this->assertTrue($casule->challenge($token, $attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider withSaltProvider
     */
    public function testSaltありでチャレンジトークンを作成する($token, $attributes)
    {
        $casule = new Casule($this->salt);

        $this->assertEquals($token, $casule->create($attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider withSaltProvider
     */
    public function testSaltありでチャレンジトークンの妥当性を確認する($token, $attributes)
    {
        $casule = new Casule($this->salt);

        $this->assertTrue($casule->challenge($token, $attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider sha512NoSaltProvider
     */
    public function testSHA512アルゴリズムでチャレンジトークンを作成する($token, $attributes)
    {
        $casule = new Casule(null, 'sha512');

        $this->assertEquals($token, $casule->create($attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider sha512NoSaltProvider
     */
    public function testSHA512アルゴリズムでチャレンジトークンの妥当性を確認する($token, $attributes)
    {
        $casule = new Casule(null, 'sha512');

        $this->assertTrue($casule->challenge($token, $attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider sha512withSaltProvider
     */
    public function testSaltありSHA512アルゴリズムでチャレンジトークンを作成する($token, $attributes)
    {
        $casule = new Casule($this->salt, 'sha512');

        $this->assertEquals($token, $casule->create($attributes));
    }

    /**
     * @param $token
     * @param $attributes
     * @dataProvider sha512withSaltProvider
     */
    public function testSaltありSHA512アルゴリズムでチャレンジトークンの妥当性を確認する($token, $attributes)
    {
        $casule = new Casule($this->salt, 'sha512');

        $this->assertTrue($casule->challenge($token, $attributes));
    }



    public function testチャレンジトークンの失敗を確認する()
    {
        $token = "invalid";
        $casule = new Casule();

        $this->assertFalse($casule->challenge($token));
        $this->assertFalse($casule->challenge($token, null));
        $this->assertFalse($casule->challenge($token, array()));
        $this->assertFalse($casule->challenge($token, array('foo' => 123)));

        $casule = new Casule($this->salt);

        $this->assertFalse($casule->challenge($token));
        $this->assertFalse($casule->challenge($token, null));
        $this->assertFalse($casule->challenge($token, array()));
        $this->assertFalse($casule->challenge($token, array('foo' => 123)));
    }
}
