@extends('layout.main')

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2></h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('/user/list') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif           
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user.permission.update', [$user->id]) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>User Role:</strong>
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="user_name" value="{{ $user->name }}">
                        <input type="hidden" name="id" value="{{ $role->id }}">
                        <input type="hidden" name="name" value="{{ $role->name }}">
                    </div>
                </div>
                <br/>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Permission:</strong>
                        <br/>
                        <?php 
                            $previous_permission="";
                            $module = array();
                            $datapush[]= "";
                        ?>
                        @foreach($permission  as $value)
                            <?php
                                $permission_name = explode( "-", $value->name);

                                $module_name = $permission_name[0];
                                if($module_name==$previous_permission){
                                    $module[$module_name][] = $permission_name[1];
                                } else{
                                    $previous_permission = $permission_name[0];
                                    $module[$module_name][] = $permission_name[1];
                                }
                            ?>
                        @endforeach
                        <?php 
                            $module_wise_permission[] = $module;
                            $upt_module = array_keys($module);
                            $i=0;
                        ?>
                        <table class="table table-bordered" style="font-size: small;">
                            <tr>
                                <th>Module</th>
                                <th>Add</th>
                                <th>Edit</th>
                                <th>View</th>
                                <th>Delete</th>
                            </tr>
                            @foreach($module as $key=>$mod)
                                <tr>
                                <td>{{ $key }} </td>
                                @foreach($mod as $per)
                                    <td>
                                        <input type="checkbox" name="permission[]" value="{{ $permission[$i]->name }}" {{ (in_array($permission[$i]->id, $rolePermissions ) ? 'checked' : '' ) }}> {{ $per }}
                                    </td>
                                    <?php $i++; ?>
                                @endforeach
                            @endforeach
                        </table>
                        <br/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>               
    </div>
@endsection
