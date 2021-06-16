<?php

namespace Zx\Weather;

use Exception;
use itbdw\Ip\IpLocation;
use Zx\Weather\Dict\District;

class Weather
{
    /**
     * @var string
     */
    protected $key;

    /**
     * Weather constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $ip
     * @param string $type
     * @param string $format
     *
     * @return string
     *
     * @throws Exception
     */
    public function getWeather($ip, $type = 'all', $format = 'json')
    {
        if (!in_array(strtolower($type), ['now', 'fc', 'index', 'alert', 'fc_hour', 'all'])) {
            throw new Exception('数据类型有:now/fc/index/alert/fc_hour/all,控制返回内容.你的:' . $type);
        }

        if (!in_array(strtolower($format), ['xml', 'json'])) {
            throw new Exception('目前支持json/xml.你的:' . $format);
        }

        $address = IpLocation::getLocation($ip);
        if (empty($city = $address['city'])) {
            throw new Exception('IP:' . $ip . '转换地址失败.');
        }

        $DistrictClass = new District();

        // 特殊地区清单
        $special = $DistrictClass->special_list();

        // 非特殊清单删除最后一个市字
        if (mb_substr($city, -1) == '市' && !in_array($city, $special)) {
            $city = mb_substr($city, 0, mb_strlen($city) - 1);
        }

        $contrast = $DistrictClass->district_list();

        if (empty($district = $contrast[$city])) {
            throw new Exception($city . ':转换行政区划编码失败.');
        }

        $type = strtolower($type);
        $format = strtolower($format);

        try {
            $response = Curl::curl("https://api.map.baidu.com/weather/v1/?district_id={$district}&data_type={$type}&output={$format}&ak={$this->key}");
            return 'json' === $format ? json_decode($response, true) : $response;
        } catch (Exception $e) {
            throw new $e;
        }
    }
}
