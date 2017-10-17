@extends('adminamazing::teamplate')

@section('pageTitle', 'Редактирование роли')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-md-12"> 
            <div class="card">
                <!-- Tab panes -->
                <div class="tab-content">                   
                    <!--second tab-->
                    <div class="card-block">
                        <form action = "{{ route('AdminRolesEdit', $role_name) }}" method = "POST" class="form-horizontal">
                            <div class="form-group">
                                <label for="role_name">Имя роли</label>                        
                                <input type = "text" class = "form-control" name = "role_name" id = "role_name" value = "{{ $role_name }}">
                            </div>
                            <h4 class="card-title">Отображаемые пункты меню</h4>
                            @foreach($menu_items as $menu_item)
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="custom-control custom-checkbox">
                                        @if(in_array($menu_item->package, $sections))
                                            <input type="checkbox" name = "sections[]" value = "{{ $menu_item->package }}" class="custom-control-input" checked>
                                        @else
                                            <input type="checkbox" name = "sections[]" value = "{{ $menu_item->package }}" class="custom-control-input">
                                        @endif
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{$menu_item->title}}</span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            {{ csrf_field() }}
                            <button class="btn btn-success btn-block">Обновить</button>                          
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(count($members) > 0)
        <!-- Column -->
        <div class="col-lg-4 col-md-12"> 
            <div class="card">
                <!-- Tab panes -->
                <div class="tab-content">                   
                    <!--second tab-->
                    <div class="card-block">
                        <h4 class="card-title">Участники</h4>
                        @foreach($members as $user)
                            <p>{{ $user->name }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        @endif
    </div>
@endsection