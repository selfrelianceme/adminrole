@extends('adminamazing::teamplate')

@section('pageTitle', 'Прикрепление роли')
@section('content')
    <div class="row">
        <!-- Column -->
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">

            <div class="card">
                <!-- Tab panes -->
                <div class="tab-content">

                    <!--second tab-->

                    
                    <div class="card-block">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <form action="{{route('AdminAffixRole')}}" method="POST" class="form-horizontal form-material">
                            <div class="form-group">
                                <label for="role" class="col-md-12">Выберите роль</label>
                                <div class="col-md-12">
                                    <select class="selectpicker" name="role" id="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user" class="col-md-12">Выберите пользователя</label>
                                <div class="col-md-12">
                                    <select class="selectpicker" name="user" id="user">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">Прикрепить роль</button>
                                </div>
                            </div>
                        </form>            
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection