@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>CREATIVE FUTURES</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>
    <div class="top-link-holder">
        <a href="{{ url('admin/add-creative-futures-session') }}" class="btn btn-primary">
            ADD SESSION
        </a>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover article-list">
            <thead>
                <tr>
                    <th width="55%">Session</td>
                    <th width="30%">Event Date(s)</td>
                    <th width="15%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Session Title
                        <br>
                        <p>
                            Description
                        </p>
                    </td>
                    <td>
                        MONTH XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('admin/edit-creative-futures-session') }}" title="Edit item">
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
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

@endsection