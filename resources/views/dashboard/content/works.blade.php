@extends('dashboard.index')

@section('userDashboard')
 
<section>
    <h1>Works / Portfolio</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>
    <div class="top-link-holder">
        <a href="{{ url('dashboard/add-work') }}" class="btn btn-primary">
            ADD WORK
        </a>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover article-list">
            <thead>
                <tr>
                    <th width="30%">Preview Image</td>
                    <th width="35%">Title</td>
                    <th width="15%">Date Created</td>
                    <th width="20%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <img src="" alt="" class="img-fluid">
                    </td>
                    <td>
                        Sample article title
                    </td>
                    <td>
                        Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('dashboard/edit-work') }}" title="Edit article">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="" title="Status">
                            <i class="fa fa-eye"></i>
                            {{-- Toggle when article is not yet published
                                <i class="fa fa-eye-slash"></i>  --}}
                        </a>
                        <a href="" title="Open link">
                            <i class="fa fa-link"></i>
                        </a>
                        <a href="" title="Delete article">
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