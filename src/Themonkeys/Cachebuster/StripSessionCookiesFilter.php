<?php namespace Themonkeys\Cachebuster;

use Illuminate\Support\Facades\Request;

class StripSessionCookiesFilter {
    private $patterns = array();

    public function addPattern($pattern) {
        if(is_array($pattern)){
            $this->patterns = array_merge($this->patterns, $pattern);
            } else {
            $this->patterns []= $pattern;
        }
    }

    public function matches($request) {
        $url = Request::path();
        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }
        return false;
    }

    public function filter($request, $response = null) {
        if ($this->matches($request)) {
            header_remove('Set-Cookie');
        }
    }
}