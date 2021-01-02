<?php

namespace Faisal50x\Xpiry;

use Carbon\Carbon;
use DateTimeInterface;
use Faisal50x\Xpiry\Contracts\XpiryInterface;

final class Xpiry implements XpiryInterface
{
    /**
     * @var Xpiry|null $instance
     */
    private static ?Xpiry $instance = null;

    private static Carbon $startAt;

    /**
     * @var Carbon|null
     */
    private static ?Carbon $startOf = null;

    /**
     * @example 1day 2 hours
     *
     * @var string $periodicTime
     */
    private static string $periodicTime;

    private function __construct()
    {
    }

    /**
     * @param DateTimeInterface|string $startAt
     * @param string $periodicTime
     * @param string|null $tz
     * @return Xpiry
     */
    public static function make($startAt, string $periodicTime, ?string $tz = null): Xpiry
    {
        if(is_null(self::$instance) || !self::$instance instanceof Xpiry) {
            self::$instance = new self();
        }
        self::$startAt = Carbon::parse($startAt, $tz);
        self::$periodicTime = $periodicTime;
        return self::$instance;
    }

    /**
     * Modify to start of current given unit.
     *
     * @example
     * ```
     * echo Xpiry::make('2018-07-25 12:45:16.334455', '1 month')
     *   ->startOf('month');
     * ```
     *
     * @param string            $unit
     * @param array<int, mixed> $params
     *
     * @return static
     */

    public static function startOf($unit, ...$params): Xpiry
    {
        self::$startOf = self::$startAt->copy()->startOf($unit, ...$params);
        return self::$instance;
    }

    /**
     * Modify to end of current given unit.
     *
     * @example
     * ```
     * echo Xpiry::make('2018-07-25 12:45:16.334455', '1 month')
     *   ->startOf('month')
     *   ->endOf('week', Carbon::FRIDAY);
     * ```
     *
     * @param string            $unit
     * @param array<int, mixed> $params
     *
     * @return static
     */
    public static function endOf($unit, ...$params): Xpiry
    {
        if (is_null(self::$startOf)) {
            self::$startOf = self::$startAt->copy()->endOf($unit, ...$params);
            return self::$instance;
        }
        self::$startOf = self::$startOf->endOf($unit, ...$params);
        return self::$instance;
    }

    /**
     * @return Carbon
     */
    public static function expireAt(): Carbon
    {
        if(is_null(self::$startOf)) {
            return self::$startAt->add(self::$periodicTime);
        }
        return self::$startOf->add(self::$periodicTime);
    }

    public function __toString():string
    {
        return self::expireAt()->toDateTimeString();
    }


}
