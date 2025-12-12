@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Members</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>

    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover member-list">
            <thead>
                <tr>
                    <th width="55%">Details</td>
                    <th width="15%">Registration Date</td>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        FULL NAME
                        <br>sample@email.com
                    </td>
                    <td>
                        Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('admin/edit-details') }}" title="Edit details">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ url('admin/view-details') }}" title="View details">
                            <i class="fa fa-file"></i>
                        </a>
                        <a href="" title="Delete record">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@endsection