@extends('layouts.app')

@section('breadcrumb')
@endsection

@section('privateContent')


<ul id="Huifold1" class="Huifold">
    @foreach($list as $cate)
          <li class="item">
            <h4 class="selected">{{$cate->name}}<b>-</b></h4>
            <div class="info"  style="display: block;" >
                    <ul id="Huifold1Child" class="Huifold1Child">
                        
                        @isset($cate->products[0])
                        @foreach($cate->products as $product)
                          <a href="{{$product->url}}" target="_blank" title="{{$product->name}}">{{$product->name}}</a> <br>
                        @endforeach
                        @endisset

                        @isset($cate->categorys[0])
                        @foreach($cate->categorys as $cateChild)
                              <li class="item">
                                <h4 class="selected" >{{$cateChild->name}}<b>-</b></h4>
                                <div class="info" style="display: block;" >
                                  @foreach($cateChild->products as $product)
                                    <a href="{{$product->url}}" target="_blank" title="{{$product->name}}">{{$product->name}}</a> <br>
                                  @endforeach

                                </div>
                              </li>
                        @endforeach
                        @endisset

                    </ul>
            </div>
          </li>
    @endforeach
</ul>

    <div>


    </div>



@endsection

@section('privateJs')
@endsection
