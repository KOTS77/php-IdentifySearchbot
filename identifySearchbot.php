<?php

/**
 * Identify Searchbots
 *
 * @author KOTS77
 *
 */
class IdentifySearchbot
{
    /*
     * @return string
     */
    private static function getClientIP()
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    /**
     * @return bool
     */
    public static function isSearchbot()
    {
        /* check if user agent contains a searchbot */
        $ip = self::getClientIP();
        
        /* server name e.g. *.googlebot.com */
        $name = gethostbyaddr($ip);

        /* check if name contains a searchbot */
        if (preg_match('/adsbot-google|googlebot|teoma|duckduckgo|mediapartners-google|mediapartner|spider|crawl|slurp|bingbot|msnbot|baidu|aolbuild/i', $name))
        {
            /* ip-list */
            $hosts = gethostbynamel($name);

            foreach ($hosts as $host)
            {
                if ($host == $ip)
                {
                    /* hello searchbot */
                    return true;
                }
            }
            return false;
        }
        else
        {
            return false;
        }
    }
}
