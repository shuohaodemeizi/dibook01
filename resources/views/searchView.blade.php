
@extends('layouts.app')

@section('breadcrumb')
    <nav class="breadcrumb">
        <div class="container">
            <i class="Hui-iconfont">&#xe67f;</i>
            <a href="/index.html" class="c-primary">首页</a>
                <span class="c-gray en">&gt;</span>
                <span class="c-gray">搜索 &nbsp;{{$kw or ''}}</span>
        </div>
    </nav>
@endsection
@section('privateContent')


    @forelse($list as $info)
        <li><div class="so-header">
                <a href="/p/{{$info->id}}.html" target="_blank" title="{{$info->name}}">{{$info->name}}</a>
            </div>
            <div class="so-body">
                <div class="so-cont">
                </div>
            </div>
            <div class="so-footer">
                <span class="pull-left">最后更新日期：{{$info->updated_at}}</span>

                @isset($info->tags)
                @foreach($info->tags as $tag)
                    <span class="pull-right"><a href="/t/{{$tag->id}}.html" class=" badge badge-secondary radius">{{$tag->name}}</a></span>
                @endforeach
                @endisset

            </div>
        </li>
    @empty
        <li>
            <article class="page-404 minWP text-c">
                <p class="error-title"><i class="Hui-iconfont va-m"></i><span class="va-m"></span></p>
                <p class="error-description">请更换关键字试试～</p>
                <p class="error-info">您还可以：<a href="javascript:;" onclick="history.go(-1)" class="c-primary">&lt; 返回上一页</a><span class="ml-20">|</span><a href="/" class="c-primary ml-20">去首页 &gt;</a></p>
            </article>

        </li>
    @endforelse

    <div>
            {{ $list->links() }}
    </div>


    <div class="col-md-4"></div>
@endsection

@section('privateJs')
@endsection


