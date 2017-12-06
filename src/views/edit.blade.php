@extends('adminamazing::teamplate')

@section('pageTitle', 'Редактирование роли')
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12"> 
            <div class="card">
                <div class="tab-content">
                    <div class="card-block">
                        <form action="{{ route('AdminRolesUpdate', $roleID) }}" method="POST" class="form-horizontal">
                            <div class="form-group">
                                <label for="role_name">Название роли</label>
                                <input type="text" class="form-control" name="role_name" id="role_name" value="{{ $roleName }}">
                            </div>
                            <h4 class="card-title">Отображаемые пункты меню</h4>
                            @foreach($menuItems as $item)
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="custom-control custom-checkbox">
                                        @if(in_array($item->package, $sections))
                                            <input type="checkbox" name="sections[]" value="{{ $item->package }}" class="custom-control-input" checked>
                                        @else
                                            <input type="checkbox" name="sections[]" value="{{ $item->package }}" class="custom-control-input">
                                        @endif
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{$item->title}}</span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <button class="btn btn-success btn-block">Обновить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(count($members) > 0)
        <div class="col-lg-4 col-md-12"> 
            <div class="card">
                <div class="tab-content">
                    <div class="card-block">
                        <h4 class="card-title">Участники</h4>
                        @foreach($members as $user)
                            <p>
                                {{ $user->name }}
                                <a href="{{ route('AdminUsersEdit', $user->id) }}" data-toggle="tooltip"><i class="fa fa fa-pencil text-inverse m-r-10"></i></a>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection