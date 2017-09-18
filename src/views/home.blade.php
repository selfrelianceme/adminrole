@extends('adminamazing::teamplate')

@section('pageTitle', 'Управление ролями')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>
                    <div class="text-right">
                        <div class="btn-group">
                            <a href="{{route('AdminCreateRole')}}" class="btn btn-success" role="button"><i class="fa fa-plus" aria-hidden="true"></i> Создать роль</a>
                            <a href="{{route('AdminAffixRole')}}" class="btn btn-success" role="button"><i class="fa fa-paperclip" aria-hidden="true"></i> Прикрепить роль</a>
                        </div>
                    </div>                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>User</th>
                                    <th>Date of appointment</th>
                                    <th class="text-nowrap">Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @inject('DB', 'Illuminate\Support\Facades\DB')
                                @foreach($users_roles as $user)
                                <tr>
                                    <td>{{DB::table('roles')->where('id', $user->role_id)->value('name')}}</td>
                                    <td>{{DB::table('users')->where('id', $user->user_id)->value('name')}}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td class="text-nowrap">     
                                        <form action="{{route('AdminDetachRole', $user->id)}}" method="POST">     
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}                                 
                                            <button class="btn btn-link" data-toggle="tooltip" data-original-title="Удалить роль пользователю"><i class="fa fa-close text-danger"></i></button>
                                        </form>
                                    </td> 
                                </tr>
                                @endforeach                             
                            </tbody>                         
                        </table>
                    </div>
                    
                </div>
            </div>
            <nav aria-label="Page navigation example" class="m-t-40">
                {{ $users_roles->links('vendor.pagination.bootstrap-4') }}
            </nav>            
        </div>
        <!-- Column -->    
    </div>
@endsection