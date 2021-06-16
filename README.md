<h1 align="center">Weather</h1>

<p align="center">基于纯真IP库与百度天气API的支持IPv4、IPv6天气组件。</p>

> 百度接口文档链接在文末


## 安装

```sh
$ composer require zhanxin/weather
```


## 配置

在使用本扩展之前，你需要去 [百度开放平台](https://lbs.baidu.com/apiconsole/key) 注册账号，然后创建应用，获取应用的 AK。


## 使用

```php
use Zx\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);
```

###  获取天气信息

```php
$response = $weather->getWeather('127.0.0.1');
```
示例：

```json
{
	"status": 0,
	"result": {
		"location": {
			"country": "中国",
			"province": "广东省",
			"city": "广州市",
			"name": "广州",
			"id": "440100"
		},
		"now": {
			"text": "多云",
			"temp": 30,
			"feels_like": 36,
			"rh": 74,
			"wind_class": "2级",
			"wind_dir": "东南风",
			"uptime": "20210615111500"
		},
		"forecasts": [{
			"text_day": "雷阵雨",
			"text_night": "雷阵雨",
			"high": 33,
			"low": 26,
			"wc_day": "3~4级",
			"wd_day": "西南风",
			"wc_night": "<3级",
			"wd_night": "静风",
			"date": "2021-06-15",
			"week": "星期二"
		}, {
			"text_day": "雷阵雨",
			"text_night": "雷阵雨",
			"high": 33,
			"low": 27,
			"wc_day": "3~4级",
			"wd_day": "南风",
			"wc_night": "<3级",
			"wd_night": "静风",
			"date": "2021-06-16",
			"week": "星期三"
		}, {
			"text_day": "雷阵雨",
			"text_night": "多云",
			"high": 34,
			"low": 28,
			"wc_day": "<3级",
			"wd_day": "静风",
			"wc_night": "<3级",
			"wd_night": "静风",
			"date": "2021-06-17",
			"week": "星期四"
		}, {
			"text_day": "雷阵雨",
			"text_night": "雷阵雨",
			"high": 34,
			"low": 26,
			"wc_day": "<3级",
			"wd_day": "静风",
			"wc_night": "3~4级",
			"wd_night": "西南风",
			"date": "2021-06-18",
			"week": "星期五"
		}, {
			"text_day": "雷阵雨",
			"text_night": "中雨",
			"high": 33,
			"low": 26,
			"wc_day": "3~4级",
			"wd_day": "南风",
			"wc_night": "3~4级",
			"wd_night": "西南风",
			"date": "2021-06-19",
			"week": "星期六"
		}]
	},
	"message": "success"
}
```

### 参数说明

```
getWeather(string $ip, string $type = 'all', string $format = 'json')
```

> - `$ip` - IP地址
> - `$type` - 请求数据类型。数据类型有：now/fc/index/alert/fc_hour/all，控制返回内容
> - `$format`  - 返回格式，目前支持json/xml


### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：

```php
     'weather' => [
        'key' => env('WEATHER_AK'),
    ],
```

然后在 `.env` 中配置 `WEATHER_AK` ：

```env
WEATHER_AK=xxxxxxxxxxxxxxxxxxxxx
```

可以用两种方式来获取 `Zx\Weather\Weather` 实例：

#### 方法参数注入

```php
    public function weather(Weather $weather) 
    {
        $response = $weather->getWeather('127.0.0.1');
    }
```

#### 服务名访问

```php
    public function weather() 
    {
        $response = app('weather')->getWeather('127.0.0.1');
    }
```

## 依赖

ip地址查询:
- [https://github.com/itbdw/ip-database](https://github.com/itbdw/ip-database)

## 参考

- [百度国内天气查询接口](https://lbs.baidu.com/index.php?title=webapi/weather)

