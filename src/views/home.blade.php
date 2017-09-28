@extends('adminamazing::teamplate')

@section('pageTitle', 'Роли админов')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>               
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs customtab2" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#list_role" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Список ролей</span></a></li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#create_role" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Создать роль</span></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-20 active" id="list_role" role="tabpanel">
                            @if(count($roles) > 0)             
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Название группы</th>
                                            <th class="text-nowrap">Действие</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td class="text-nowrap">     
                                                <form action="{{ route('AdminRolesDelete', $role->name) }}" method="POST">     
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <a href="{{ route('AdminRolesEdit', $role->name) }}" data-toggle="tooltip" data-original-title="Редактировать"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <button class="btn btn-link" data-toggle="tooltip" data-original-title="Удалить"><i class="fa fa-close text-danger"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach                             
                                    </tbody>                         
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> Информация</h3> На данный момент отсутствуют роли
                            </div>
                            @endif                         
                        </div>
                        <div class="tab-pane p-20" id="create_role" role="tabpanel">
                            <div class="card-block">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
                                <form action="{{route('AdminRolesCreate')}}" method="POST" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="name" class="col-md-12">Имя</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="" class="form-control form-control-line" name="name" id="name">
                                            <div class="text-right"><button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#privilegions">Показать/Скрыть разделы</button></div>
                                            <div id="privilegions" class="collapse">
                                                @foreach($decodeArrayJson as $oneJson)
                                                    @if(array_key_exists('prefix', $oneJson))
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="privilegion_{{$oneJson->prefix}}" class="custom-control-input">
                                                                <span class="custom-control-indicator"></span>
                                                                <span class="custom-control-description">{{$oneJson->description}}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>                                        
                                    </div>
                                    {{ csrf_field() }}
                                    <div class="col-sm-12">
                                        <button class="btn btn-success btn-md">Создать роль</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>            
        </div>
        <!-- Column -->    
    </div>
@endsection