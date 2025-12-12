@extends('dashboard.index')

@section('userDashboard')
 
<section>
    <h1>Inbox</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover inbox-list">
            <thead>
                <tr>
                    <th width="30%">Subject Line</td>
                    <th width="30%">Sender</td>
                    <th width="20%">Time & Date Received</td>
                    <th width="20%">Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr class="new" >
                    <td>
                        Subject Line
                    </td>
                    <td>
                        Sender Name
                    </td>
                    <td>
                        hh:mm:ss | Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('dashboard/message') }}" title="Open">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <a href="" data-toggle="modal" data-target="#replyToMessage" title="Reply" title="Reply">
                            <i class="fa fa-reply"></i>
                        </a>
                        <a href="" title="Delete article">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Subject Line
                    </td>
                    <td>
                        Sender Name
                    </td>
                    <td>
                        Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="{{ url('dashboard/message') }}" title="Read">
                            <i class="fa fa-envelope-open-text"></i>
                        </a>
                        <a href="" data-toggle="modal" data-target="#replyToMessage" title="Reply" title="Reply">
                            <i class="fa fa-reply"></i>
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

  
@include('dashboard.components.replyTo')

@endsection