<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 11.07.18
 * Time: 0:23
 */

namespace App\Console\Commands\Api;

use Illuminate\Console\Command;

class DocCommand extends  Command
{
    protected $signature = 'api:doc';
    public function handle()
    {
        $swagger = base_path('vendor/bin/swagger');
        $source = app_path('Http');
        $target = public_path('docs/swagger.json');

        passthru('"' . PHP_BINARY . '"' . " \"{$swagger}\" \"{$source}\" --output \"{$target}\"");
    }
}