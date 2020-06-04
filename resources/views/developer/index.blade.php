@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ mix('/static/css/developer.css') }}" type="text/css">
    @parent
@endsection

@section('title', 'Developer')

@section('content')
    @foreach ($list as $item)
    {{ $item->api_token }}
    @endforeach

    {{ $list->links() }}

@endsection

@section('js')
    @parent
    <script src="{{ mix('/static/js/developer/index.js') }}"></script>
@endsection


