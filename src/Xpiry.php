<?php

namespace Faisal50x\Xpiry;

use Carbon\Carbon;
use DateTimeInterface;
use Faisal50x\Xpiry\Contracts\XpiryInterface;

final class Xpiry implements XpiryInterface
{
    /**
     * @var Xpiry|null
     */
    private static ?Xpiry $instance = null;

    private static Carbon $startAt;

    /**
     * @var array|null
     */
    private static ?array $startOf = null;

    /**
     * @var array|null
     */
    private static ?array $endOf = null;

    /**
     * @example 1day 2 hours
     *
     * @var string
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
        if (is_null(self::$instance) || ! self::$instance instanceof Xpiry) {
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
        self::$startOf = ['unit' => $unit, "params" => $params];

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
        self::$endOf = ['unit' => $unit, "params" => $params];

        return self::$instance;
    }

    /**
     * @return Carbon
     */
    public static function expireAt(): Carbon
    {
        if (is_null(self::$startOf) && is_null(self::$endOf)) {
            return self::$startAt->add(self::$periodicTime);
        }
        if (! is_null(self::$startOf) && is_null(self::$endOf)) {
            return self::$startAt
                ->startOf(self::$startOf['unit'], ...self::$startOf['params'])
                ->add(self::$periodicTime)
                ->sub(self::caseUnit(self::$startOf['unit']));
        }

        return self::$startAt->add(self::$periodicTime);
    }

    private static function caseUnit(string $unit)
    {
        switch ($unit) {
            case 'month': case 'week':
                return '1 day';
            case 'day':
                return '1 hour';
            case 'hour':
                return '1 minute';
            case 'minute':
                return '1 second';
            default:
                return '';
        }
    }

    public function __toString():string
    {
        return self::expireAt()->toDateTimeString();
    }
}
