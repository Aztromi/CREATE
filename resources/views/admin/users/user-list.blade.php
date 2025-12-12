@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>User List</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>
    <div class="top-link-holder">
        <a href="{{ url('admin/add-user') }}" class="btn btn-primary">
            ADD User
        </a>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover article-list">
            <thead>
                <tr>
                    <th width="15%">Photo</td>
                    <th width="50%">User</td>
                    <th width="20%">Type</td>
                    <th width="15%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img src="" alt="" class="img-fluid">
                    </td>
                    <td>
                        Full Name
                    </td>
                    <td>
                        Super Administrator
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('admin/edit-user-details') }}" title="Edit item">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="" title="Delete item">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@endsection