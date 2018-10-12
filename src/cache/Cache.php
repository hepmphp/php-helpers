<?php


namespace okfish\lib\cache;


abstract class Cache {
    public $cache_prefix = 'CACHE_';
    public function set($id,$data,$ttl){}
    public function get($id){}
    public function sets($datas,$ttl){}
    public function gets($ids){}
    public function delete($id){}
    public function clean(){}
    public function cache_info(){}
    /**
     * 生成缓存key
     * @param $key   搜索的参数
     * @return string 缓存字符串
     */
    public function build_cache_key($key){
        if(is_string($key))
        {
            $key = ctype_alnum($key)&&mb_strlen($key)<32?$key:md5($key);
        }else{
            $key = md5(json_encode($key));
        }
        return $this->cache_prefix.$key;
    }


}