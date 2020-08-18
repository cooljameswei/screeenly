<?php

namespace Screeenly\Services;

use Screeenly\Contracts\CanCaptureScreenshot;
use Screeenly\Entities\Screenshot;
use Screeenly\Entities\Url;
use Spatie\Browsershot\Browsershot;

class ChromeBrowser extends Browser implements CanCaptureScreenshot
{
    public function capture(Url $url, $storageUrl)
    {
        $browser = Browsershot::url($url->getUrl())
            ->ignoreHttpsErrors()
            ->windowSize($this->width, is_null($this->height) ? 768 : $this->height)
            ->timeout(30)
            ->setDelay($this->delay * 1000)
            ->userAgent('screeenly-bot 2.0');


        if (config('screeenly.disable_sandbox')) {
            $browser->noSandbox();
        }

        if (is_null($this->height)) {
            $browser->fullPage();
        }

        $browser->save($storageUrl);

        return new Screenshot($storageUrl);
    }
}
