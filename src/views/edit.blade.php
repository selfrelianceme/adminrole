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
                        <h4 class="card-title">Меню</h4>
                        <div class="myadmin-dd-empty dd" id="nestable2">
                            <ol class="dd-list">
                                {!!$tree!!}
                                <textarea style="display:none;" id="nestable-output" type="hidden"></textarea>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            {{ csrf_field() }}
                            <button class="btn btn-success btn-block">Обновить</button>                          
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-4 col-md-12"> 
            <div class="card">
                <!-- Tab panes -->
                <div class="tab-content">                   
                    <!--second tab-->
                    <div class="card-block">
                        <h4 class="card-title">Участники</h4>
                        @foreach($members as $user)
                            <p>
                                @php
                                    echo (\DB::table('users')->where('id', $user->user_id)->value('name'));
                                @endphp
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection