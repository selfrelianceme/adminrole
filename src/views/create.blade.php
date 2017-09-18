@extends('adminamazing::teamplate')

@section('pageTitle', 'Создание роли')
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

                        <form action="{{route('AdminCreateRole')}}" method="POST" class="form-horizontal form-material">
                            <div class="form-group">
                                <label for="name_role" class="col-md-12">Имя роли</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" class="form-control form-control-line" name="name_role" id="name_role">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="slug_role" class="col-md-12">Имя обращения</label>
                                <div class="col-md-12">
                                     <input type="text" placehorder="" class="form-control form-control-line" name="slug_role" id="slug_role">
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
        <!-- Column -->
    </div>
@endsection