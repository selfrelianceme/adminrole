@extends('adminamazing::teamplate')

@section('pageTitle', 'Роли')
@section('content')
    @push('scripts')
        <script>
            var route = '{{ route('AdminRolesDelete') }}';
            message = 'Вы точно хотите удалить данную роль?';
        </script>
    @endpush
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>
                    <ul class="nav nav-tabs customtab2" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list_role" role="tab"><span class="hidden-sm-up"></span><span class="hidden-xs-down">Список ролей</span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#create_role" role="tab"><span class="hidden-sm-up"></span><span class="hidden-xs-down">Создать  роль</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane p-20 active" id="list_role" role="tabpanel">
                            @if(count($roles) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Название роли</th>
                                            <th class="text-nowrap">Действие</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td class="text-nowrap">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <a href="{{ route('AdminRolesEdit', $role->id) }}" data-toggle="tooltip" data-original-title="Редактировать"><i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                                <a href="#deleteModal" class="delete_toggle" data-id="{{ $role->id }}" data-toggle="modal"><i class="fa fa-close text-danger"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                                        <label for="name" class="col-md-6">Название роли</label>
                                        <div class="col-md-6">
                                            <input type="text" name="role_name" id="name" class="form-control form-control-line">
                                            @foreach($menuItems as $menu_item)
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name = "sections[]" value = "{{ $menu_item->package }}" class="custom-control-input">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">{{$menu_item->title}}</span>
                                                    </label>
                                                </div>
                                           	</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
                                    <div class="col-sm-12">
                                        <button class="btn btn-success btn-md">Создать</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection