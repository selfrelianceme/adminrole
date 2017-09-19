@extends('adminamazing::teamplate')

@if($type == 'roles') @section('pageTitle', 'Управление ролями')
@elseif($type == 'permissions') @section('pageTitle', 'Управление правами')
@endif
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>
                    <div class="text-right">
                        <div class="btn-group">
                            @if($type == 'roles')
                            <a href="{{route('AdminCreate', 'roles')}}" class="btn btn-success" role="button"><i class="fa fa-plus" aria-hidden="true"></i> Создать роль</a>
                            <a href="{{route('AdminAffix', 'roles')}}" class="btn btn-success" role="button"><i class="fa fa-paperclip" aria-hidden="true"></i> Прикрепить роль</a>
                            @elseif($type == 'permissions')
                            <a href="{{route('AdminCreate', 'permissions')}}" class="btn btn-success" role="button"><i class="fa fa-plus" aria-hidden="true"></i> Создать права</a>
                            <a href="{{route('AdminAffix', 'permissions')}}" class="btn btn-success" role="button"><i class="fa fa-paperclip" aria-hidden="true"></i> Прикрепить права</a>
                            @endif
                        </div>
                    </div>                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    @if($type == 'roles') <th>Role</th>
                                    @elseif($type == 'permissions') <th>Permission</th>
                                    @endif
                                    <th>User</th>
                                    <th>Date of appointment</th>
                                    <th class="text-nowrap">Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @inject('DB', 'Illuminate\Support\Facades\DB')
                                @foreach($what_to_transfer as $transfer)
                                @if($type == 'roles')
                                <tr>
                                    <td>{{DB::table('roles')->where('id', $transfer->role_id)->value('name')}}</span></td>
                                    <td>{{DB::table('users')->where('id', $transfer->user_id)->value('name')}}</td>
                                    <td>{{ $transfer->created_at }}</td>
                                    <td class="text-nowrap">     
                                        <form action="{{route('AdminDetach', ['id'=>$transfer->id, 'type'=>$type])}}" method="POST">     
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}                                 
                                            <button class="btn btn-link" data-toggle="tooltip" data-original-title="Удалить роль пользователю"><i class="fa fa-close text-danger"></i></button>
                                        </form>
                                    </td> 
                                </tr>
                                @elseif($type == 'permissions')
                                <tr>
                                    <td>{{DB::table('permissions')->where('id', $transfer->role_id)->value('name')}}</span></td>
                                    <td>{{DB::table('users')->where('id', $transfer->user_id)->value('name')}}</td>
                                    <td>{{ $transfer->created_at }}</td>
                                    <td class="text-nowrap">
                                        <form action="{{route('AdminDetach', ['id'=>$transfer->id, 'type'=>$type])}}" method="POST">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-link" data-toggle="tooltip" data-original-title="Удалить права пользователю"><i class="fa fa-close text-dange"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @endforeach                             
                            </tbody>                         
                        </table>
                    </div>
                    
                </div>
            </div>
            <nav aria-label="Page navigation example" class="m-t-40">
                {{ $what_to_transfer->links('vendor.pagination.bootstrap-4') }}
            </nav>            
        </div>
        <!-- Column -->    
    </div>
@endsection