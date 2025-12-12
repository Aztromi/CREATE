@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Creative Industries</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>
    <div class="top-link-holder">
        <a href="{{ url('admin/add-creative-industry') }}" class="btn btn-primary">
            ADD INDUSTRY
        </a>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover article-list">
            <thead>
                <tr>
                    <th width="80%">Industry</td>
                    <th width="20%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Item
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('admin/edit-creative-industry') }}" title="Edit item">
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
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@endsection