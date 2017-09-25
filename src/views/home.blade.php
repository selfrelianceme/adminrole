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
                                            <th>ID</th>
                                            <th>Имя</th>
                                            <th class="text-nowrap">Действие</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td class="text-nowrap">     
                                                <form action="{{route('AdminRolesDelete', ['id' => $role->id])}}" method="POST">     
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button class="btn btn-link" data-toggle="tooltip" data-original-title="Удалить роль"><i class="fa fa-close text-danger"></i></button>
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
                                <form action="{{route('AdminRolesCreate')}}" method="POST" class="form-horizontal form-material">
                                    <div class="form-group">
                                        <label for="name" class="col-md-12">Имя</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="" class="form-control form-control-line" name="name" id="name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug" class="col-md-12">Имя обращения</label>
                                        <div class="col-md-12">
                                             <input type="text" placehorder="" class="form-control form-control-line" name="slug" id="slug">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-md-12">Описание</label>
                                        <div class="col-md-12">
                                           <textarea style="height:220px" class="form-control form-control-line" name="description" id="description"></textarea>
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Создать роль</button>
                                        </div>
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