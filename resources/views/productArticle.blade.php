@extends('layouts.app')

@section('breadcrumb')
@endsection

@section('privateContent')

    <div class="row bg-gray pt-15">
        <div class="col-md-8">
            <div class="col-box">
                <div class="col-article">
                    <div class="art-header">
                        <h1 class="title">{{$product->name}}</h1>
                        <div class="art-meta"><span>ID：{{$product->id}} </span><span>更新日期：{{$product->updated_at}}</span></div>
                    </div>
                    <div class="art-body">

                        {!! $product->fulltext !!}
                    </div>
                    <div class="art-body">
                        @isset($product->categorys)
                        @foreach ($product->categorys as $category)
                            <a href="/c/{{$category->id}}" class=" badge badge-primary radius">{{$category->name}}</a>
                        @endforeach
                        @endisset

                        @isset($product->tags)
                            @forelse ($product->tags as $tag)
                            <a href="/t/{{$tag->id}}" class=" badge badge-primary radius">{{$tag->name}}</a>
                            @endforeach
                        @endisset

                    </div>
                </div>

                <div class="col-art-footer">
                    <ul>
                        @isset($pProduct)
                        <li><span>上一篇：</span><a href="/p/{{$pProduct->id}}.html">{{$pProduct->name}}</a></li>
                        @endisset
                        @isset($nProduct)
                        <li><span>下一篇：</span><a href="/p/{{$nProduct->id}}.html">{{$nProduct->name}}</a></li>
                        @endisset
                    </ul>
                </div>
            </div>



            <div class="col-box">
                <div class="col-sub-tit"><span class="tit">相关文章</span></div>
                <div class="col-body">
                    <ul class="col-relation">

                        @isset($product->products)
                        @foreach ($product->products as $item)
                            <li><a title="{{$item->name}}" href="/p/{{$item->id}}.html">{{$item->name}}</a></li>
                        @endforeach
                        @endisset

                    </ul>
                </div>
            </div>

            <!-- comment -->


        </div>




                        @isset($groups)
                        @foreach($groups as $group)
            <div class="col-md-4">
            <div class="col-box"><div class="col-box-header">
                    <span>
                        <a target="_blank" href="/c/{{$group['info']->id}}.html" class="badge badge-primary radius">{{$group['info']->name}}</a>
                    </span>
                </div>
                <div class="col-box-list">
                    <ul>
                        @foreach($group['list'] as $k=>$item)
                            <li><a href="/p/{{$item->id}}.html">{{$item->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            </div>
                        @endforeach
                        @endisset



        <div class="col-md-4"></div>
    </div>

@endsection

@section('privateJs')

@endsection