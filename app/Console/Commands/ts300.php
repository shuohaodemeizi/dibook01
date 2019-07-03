<?php

namespace App\Console\Commands;

use App\Models\Garbages;
use App\Models\ProductItems;
use App\Models\Topics;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use JonnyW\PhantomJs\Client;

class ts300 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ts300';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '唐诗300';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*
         * 感谢以下项目的贡献者：

中华古诗词数据库
https://github.com/chinese-poetry/chinese-poetry

A simple, fast, and fun package for building command line apps in Go
https://github.com/urfave/cli

Tiny cross-platform webview library for C/C++/Golang
https://github.com/zserge/webview

A Vue.js 2.0 UI Toolkit for Web
https://github.com/ElemeFE/element

ImageMagick 7
https://github.com/ImageMagick/ImageMagick

Set the desktop wallpaper on Windows
https://github.com/sindresorhus/win-wallpaper

        mysql：https://github.com/KomaBeyond/chinese-poetry-mysql
         * */



    }
}
