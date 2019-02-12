<?php

namespace mradang\LumenDingtalk\Controllers;

use Illuminate\Http\Request;
use mradang\LumenDingtalk\Services\DingTalkService;

class DingTalkController extends Controller {

    public function config(Request $request) {
        $validatedData = $this->validate($request, [
            'url' => 'required|string',
            'jsApiList' => 'required|string',
        ]);

        $jsApiList = explode('|', $request->jsApiList);
        return DingTalkService::config($request->url, $jsApiList);
    }

}
