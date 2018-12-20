@extends('layouts.app')

@section('breadcrumb')
@endsection

@section('privateContent')


    @foreach($list as $info)
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

    @endforeach

    <div>
            {{ $list->links() }}
    </div>



@endsection

@section('privateJs')
@endsection


