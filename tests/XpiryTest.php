<?php

namespace Faisal50x\Xpiry\Tests;

use Carbon\Carbon;
use Faisal50x\Xpiry\Xpiry;
use PHPUnit\Framework\TestCase;

class XpiryTest extends TestCase
{
    /** @test */
    public function check_instance_of_xpiry()
    {
        $xpiry = Xpiry::make('2020-01-01', '1 hour');
        $this->assertInstanceOf('Faisal50x\Xpiry\Xpiry', $xpiry);
    }

    /** @test */
    public function add_one_month_periodic_time()
    {
        $xpiry = Xpiry::make('2021-01-10', '1 month');
        $this->assertEquals('2021-02-09 23:59:59', $xpiry->expireAt()->toDateTimeString());
    }

    /** @test */
    public function it_should_be_start_from_start_of_month()
    {
        $xpiry = Xpiry::make('2021-01-10', '1 month')
            ->startOf(Xpiry::MONTH);
        $this->assertEquals('2021-01-31 23:59:59', $xpiry->expireAt()->toDateTimeString());
    }

    /** @test */
    public function it_should_be_start_from_next_month()
    {
        $xpiry = Xpiry::make('2021-01-10', '1 month')
            ->endOf(Xpiry::MONTH);
        $this->assertEquals('2021-03-03 23:59:59', $xpiry->expireAt()->toDateTimeString());
    }


    public function add_two_days_start_of_week()
    {

        $xpiry = Xpiry::make('2021-01-07', '2 days')
            ->startOf(Xpiry::WEEK);
        $this->assertEquals('2021-01-04 23:59:59', $xpiry->expireAt()->toDateTimeString());
    }
}
