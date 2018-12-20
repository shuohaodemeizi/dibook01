@include('layouts._head')
@section('minimenu')
    @include('layouts._defaultMiniMenu')
@show

<div class="containBox">
    <div class="containBox-bg"></div>

    @section('menu')
        @include('layouts._defaultMenu')
    @show

    <div class="wap-container">

        @section('slider-3')
            {{--@include('layouts._defaultSlider-3')--}}
        @show

        @section('breadcrumb')
            @include('layouts._defaultBreadcrumb')
        @show

        <div class="container ui-sortable bg-gray">
            <!--<h1></h1>-->

            <div class="col-search-list">
                <ul>
                    @section('privateContent')
                    <!-- js app -->
                    <!-- js app -->
                    <!-- js app -->
                    @show
                </ul>
            </div>

        </div>

        @section('footer')
                <!-- footer -->
            @include('layouts._footer')
        @show

    </div>
</div>


@section('footlast')
        <!-- comment div js -->
    @include('layouts._footlast')
@show


@section('privateJs')
        <!-- js -->
@show