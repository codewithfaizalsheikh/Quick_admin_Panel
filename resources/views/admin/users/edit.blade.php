@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title">
                {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
            </h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.user.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                    @if ($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('cruds.user.fields.email') }}*</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                    @if ($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.email_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input type="password" id="password" name="password" class="form-control">
                    @if ($errors->has('password'))
                        <p class="help-block">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.password_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
                    <label for="roles">{{ trans('cruds.user.fields.roles') }}*
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="roles[]" id="roles" class="form-control select2" multiple="multiple" required>
                        @foreach ($roles as $id => $roles)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('roles', [])) || (isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                {{ $roles }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('roles'))
                        <p class="help-block">
                            {{ $errors->first('roles') }}
                        </p>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.roles_helper') }}
                    </p>
                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


            <form  id="user-edit-form">
                @csrf
                <input type="text" id="edit_user_id"><br>
                <label>name</label><br>
                <input type="text" value="" id="edit-name"><br>
                <label>Email</label><br>
                <input type="text" value="" id="edit-email"><br>
                {{-- <label>Password</label><br>
                <input type="text" value="" id="edit-password"><br> --}}
                {{-- <label>Roles</label><br>
                <input type="text" value="" id="edit-roles"><br> --}}
                <a type="submit" id="update_User" class="btn btn-primary">update</a>
            </form>


        </div>
    </div>
@endsection
@section('scripts')
    <script>
        fetchUser()
        function fetchUser() {
            var user_id = '{{ $user->id }}';
            // alert(user_id);
            var url = "{{route('api.user.editUser','') }}"+ '/' + user_id;
            // alert(url)
            $.ajax({
                type:'get',
                url:url,
                dataType:'json',
                success:function (response){
                    console.log(response.user);
                    var res_edit_user = response.user;
                    $('#edit-name').val(res_edit_user.name);
                    $('#edit_user_id').val(res_edit_user.id);
                    $('#edit-email').val(res_edit_user.email);
                
                }


            });
        }

        $(document).ready(function(){
            $(document).on('click','#update_User',function(e){
                e.preventDefault();
                
                var user_update_id = $('#edit_user_id').val();
                
                console.log(user_update_id)
                var data = {
                    'name' : $('#edit-name').val(),
                    'email' : $('#edit-email').val(),
                    'password' : $('#edit-password').val(),
                }
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = "{{ route('api.user.updateUser','')}}" +'/'+ user_update_id;
                // alert(data);
                $.ajax({
                    type:'put',
                    url:url,
                    dataType:'json',
                    success: function(response){
                        console.log(response)

                    }

                })
            })
        })
    </script>
@endsection
