<!DOCTYPE html>
<html lang="en">
    
{{-- Head --}}
@include('admin.layouts.blocks.head')
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">

{{-- Header --}}
@include('admin.layouts.blocks.header')

{{-- Sidebar --}}
@include('admin.layouts.blocks.sidebar')

<div class="page-wrapper">
    {{-- main --}}
@yield('content')
@yield('page')
</div>
</div>
{{-- script --}}
@include('admin.layouts.blocks.script')

</body>
</html>