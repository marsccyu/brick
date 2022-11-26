@extends('layouts.app')

@section('content')
    <div class="container">

        <form method="POST" class="appointment-form" id="appointment-form" action="{{ route('register') }}">
            @csrf
            <h2> {{ ($title ?? "秘密積地") }} - 綁定您的 Line 帳號 </h2>
            @if($registered)
                <div class="alert alert-success">
                您的 Line 帳號已完成綁定。
            </div>
            @else
                <div class="form-group-1">
                    <input type="text" name="name" id="name" placeholder="學生姓名" value="{{ old('name') }}" required />
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required />
                    <input type="number" name="telephone" id="telephone" placeholder="聯絡電話" value="{{ old('telephone') }}" required />
                    <input type="number" name="age" id="age" placeholder="年齡" value="{{ old('age') }}" required />
                    <input type="hidden" name="userId" id="userId" value="{{ $uid }}" required />
                    <div class="select-list" style="margin-bottom: 0px;">
                        <select name="type" id="type">
                            <option slected disabled value="">您的身分</option>
                            <option value="student">學生</option>
                            <option value="parents">家長</option>
                        </select>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <p> - {{ $error }}</p>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-submit">
                    <input type="submit" name="submit" id="submit" style="width:100%" class="submit" value="送出" />
                </div>
            @endif
        </form>
    </div>
    <!-- <a href="https://line.me/R/oaMessage/@053clhcl/?hello">L</a> -->
@endsection
