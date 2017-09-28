@extends('adminamazing::teamplate')

@section('pageTitle', 'Редактирование роли')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7"> 
            <div class="card">
                <!-- Tab panes -->
                <div class="tab-content">                   
                    <!--second tab-->
                    <div class="card-block">
                        <form action="{{route('AdminRolesUpdate', $name)}}" method="POST" class="form-horizontal">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}                       
                            <div class="form-group">
                                <label for="name" class="col-2 col-form-label">Имя</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="{{ $name }}" name="name" id="name">
                                    <div class="text-right"><button class="btn btn-primary btn-md" data-toggle="collapse" data-target="#privilegions">Показать/Скрыть разделы</button></div>
                                    <div id="privilegions" class="collapse show">
                                    @foreach($decodeArrayJson as $oneJson)                                                                              
                                        @if(array_key_exists('prefix', $oneJson))
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="custom-control custom-checkbox">
                                                        @if(in_array($oneJson->prefix, $privilegions))
                                                            <input type="checkbox" name="privilegion_{{$oneJson->prefix}}" class="custom-control-input" checked>
                                                        @else
                                                            <input type="checkbox" name="privilegion_{{$oneJson->prefix}}" class="custom-control-input">
                                                        @endif
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">{{$oneJson->description}}</span>
                                                    </label>
                                                </div>
                                            </div>                                           
                                        @endif
                                    @endforeach
                                    </div> 
                                </div>
                                <div class="col-sm-12">
                                    <button class="btn btn-success btn-md">Сохранить</button>
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