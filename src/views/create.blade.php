@extends('adminamazing::teamplate')

@if($type == 'roles') @section('pageTitle', 'Создание роли')
@elseif($type == 'permissions') @section('pageTitle', 'Создание прав')
@endif
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

                        <form action="{{route('AdminCreate', $type)}}" method="POST" class="form-horizontal form-material">
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
                                    @if($type == 'roles') <button class="btn btn-success">Создать роль</button>
                                    @elseif($type == 'permissions') <button class="btn btn-success">Создать права</button>
                                    @endif
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