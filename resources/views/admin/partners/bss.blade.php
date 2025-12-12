@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Business Solutions Services</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>
    <div class="top-link-holder">
        <a href="{{ url('admin/add-business-solutions-partner') }}" class="btn btn-primary">
            ADD Business Solutions Partner
        </a>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover bss-list">
            <thead>
                <tr>
                    <th width="50%">Name</td>
                    <th width="10%">Featured</td>
                    <th width="20%">Date Updated</td>
                    <th width="20%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Name
                        <br>
                        <a href="mailto:">
                            email@sample.com
                        </a>
                    </td>
                    <td>
                        <div class="status_verified">
                            YES
                        </div>
                    </td>
                    <td>
                        XX:XX XM | Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('admin/edit-business-solutions-partner') }}" title="Edit item">
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