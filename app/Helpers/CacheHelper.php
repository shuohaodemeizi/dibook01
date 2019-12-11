<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Cache;

/**
 * @author TsaiKoga
 * @version 1.0.0
 */
class CacheHelper
{
    /**
     * Create a new command instance.
     *
     * @param  string $driver
     * @return
     */
    public function __construct()
    {
        $this->driver = config('cache.default');
        $this->driver_prefix = config('cache.prefix');
    }

    /**
     * get the all keys by prefix
     *
     * @param string $prefix
     * @return array
     */
    public function getKeysByPrefix($prefix)
    {
        if (empty($prefix)) throw new \Exception("Cannot get the included keys without prefix string!", 1);
        $prefix = $this->driver_prefix . ':' . $prefix;
        if ($this->driver != 'redis') throw new \Exception("暂时只支持获取 Redis 缓存", 1);

        $method_name = 'getKeysBy'.ucfirst(camel_case($this->driver)).'Prefix';
        return call_user_func(array($this, $method_name), $prefix);
    }

    /**
     * get the all keys by prefix on filesystem
     *
     * @param string $prefix
     * @return array
     */
    public function getKeysByFilePrefix($prefix) {
        $redis = Cache::getRedis();
        $included_keys = $redis->keys($prefix . "*");
        return $included_keys;
    }

    /**
     * get the all keys by prefix
     *
     * @param string $prefix
     * @return array
     */
    public function getKeysByRedisPrefix($prefix) {
        $redis = Cache::getRedis();
        $included_keys = $redis->keys($prefix . "*");
        return $included_keys;
    }

    /**
     * forget keys by prefix
     *
     * @param string $prefix
     * @return bool
     */
    public function forgetKeysByPrefix($prefix)
    {
        if (empty($prefix)) throw new \Exception("Cannot get the included keys without prefix string!", 1);
        $prefix = $this->driver_prefix . ':' . $prefix;
        if ($this->driver != 'redis') throw new \Exception("暂时只支持删除Redis缓存", 1);

        $method_name = 'forgetKeysBy'.ucfirst(camel_case($this->driver)).'Prefix';
        return call_user_func(array($this, $method_name), $prefix);
    }

    /**
     * forget keys by prefix
     *
     * @param string $prefix
     * @return bool
     */
    public function forgetKeysByRedisPrefix($prefix)
    {
        $redis = Cache::getRedis();
        $keys = $this->getKeysByRedisPrefix($prefix);
        foreach($keys as $key) {
            $res = $redis->del($key);
            if (!$res) return false;
        }
        return true;
    }

}
