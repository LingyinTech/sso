@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ mix('/static/css/developer.css') }}" type="text/css">
@endsection

@section('title', 'Developer')

@section('content')
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">序号</th>
            <th scope="col">API Token</th>
            <th scope="col">ip 白名单</th>
            <th scope="col">更新时间</th>
            <th scope="col">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $key => $item)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ $item->api_token }}</td>
                <td>{{ $item->white_list }}</td>
                <td>{{ $item->updateAt }}</td>
                <td>
                    <span class="btn btn-light action-edit">更新</span>
                    <span class="btn btn-danger action-delete">删除</span>
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td>
                <textarea class="form-control" name="white_list"></textarea>
            </td>
            <td></td>
            <td>
                <span class="btn btn-light action-add">新增</span>
            </td>
        </tr>
        </tbody>

    </table>

    {{ $list->links() }}

@endsection

@section('js')
    @parent
    <script src="{{ mix('/static/js/developer/index.js') }}"></script>
@endsection


