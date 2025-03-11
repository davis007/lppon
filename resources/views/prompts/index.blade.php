@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('プロンプト一覧') }}</span>
                    <a href="{{ route('prompts.create') }}" class="btn btn-primary btn-sm">{{ __('新規作成') }}</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (count($prompts) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('タイトル') }}</th>
                                        <th>{{ __('コンセプト') }}</th>
                                        <th>{{ __('作成日') }}</th>
                                        <th>{{ __('操作') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prompts as $prompt)
                                        <tr>
                                            <td>{{ $prompt->title }}</td>
                                            <td>{{ $prompt->concept }}</td>
                                            <td>{{ $prompt->created_at->format('Y/m/d H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('prompts.show', $prompt) }}" class="btn btn-info btn-sm">{{ __('表示') }}</a>
                                                    <a href="{{ route('prompts.edit', $prompt) }}" class="btn btn-warning btn-sm">{{ __('編集') }}</a>
                                                    <form action="{{ route('prompts.destroy', $prompt) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('本当に削除しますか？') }}')">{{ __('削除') }}</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $prompts->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('プロンプトがまだありません。「新規作成」ボタンから作成してください。') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
