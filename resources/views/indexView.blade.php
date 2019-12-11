@extends('layouts.app')

@section('breadcrumb')
@endsection

@section('privateContent')


<ul id="Huifold1" class="Huifold1111111">
    @foreach($list->categorys as $info)
          <li class="item">
            <h4>{{$info->name}}<b>+</b></h4>
            <div class="info" >
                @foreach($info->products as $product)
                  <a href="{{$product->url}}" target="_blank" title="{{$product->name}}">{{$product->name}}</a> <br>

                  @isset($product->tags)
                  @foreach($product->tags as $tag)
                      <span class="pull-right"><a href="/t/{{$tag->id}}.html" class=" badge badge-secondary radius">{{$tag->name}}</a></span>
                  @endforeach
                  @endisset
                @endforeach
            </div>
          </li>
    @endforeach
</ul>

    <div>
            
    </div>



@endsection

@section('privateJs')
@endsection
