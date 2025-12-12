@extends('admin.index')

@section('styles')
    @include('components.styles-DataTable')
@endsection

@section('scripts-bottom')
    @include('components.scripts-DataTable')
@endsection

@section('contentAdmin')

    @section('userDash_appRequest')
    <script src="{{ asset('js/admin/applicationRequest.js?ver='.time()) }}"></script>

    @endsection


 
<section>
    <h1>Application Request List</h1>
    <hr>
    <!-- <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
        
    </div> -->

    <div class="top-link-holder">
        <a href="{{ url('admin/add-member') }}" class="btn btn-primary">
            ADD Member
        </a>
    </div>

    <div class="custom-dropdown">
        <label for="status-filter">Filter by Status:</label>
        <select id="status-filter">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="member">Member</option>
            <option value="unverified">Unverified</option>
            <option value="verified">Verified</option>
            <option value="denied">Denied</option>
        </select>
    </div>
    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover application-list" id="requests-data-table">
            <thead>
                <tr>
                    <th width="40%">Details</td>
                    <th width="15%">Status</td>
                    <th width="15%">Registration Date</td>
                    <th width="15%">Last Update</td>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        @if($user->profile)
                            {{ $user->profile->dispName }}
                        @else
                            {{ $user->name }}
                        @endif
                        <br>{{ $user->email }}
                    </td>
                    <td id="status-{{ $user->id }}" data-a="{{ $user->approved }}" data-v="{{ $user->verified }}">
                        @if($user->verified == 1)
                            <p hidden>0F5J3F7R</p>
                        @endif
                        <div class="
                            @if($user->status <> 'active')
                                status_denied
                            @elseif($user->requests <> 0)
                                status_pending
                            @elseif($user->verified == 1)
                                status_verified
                            @elseif($user->verified == 0)
                                status_unverified
                            @elseif($user->verified == -1)
                                status_member
                            @endif
                        ">
                            @if($user->status <> 'active')
                                Denied
                            @elseif($user->requests <> 0)
                                Pending
                            @else
                                {{ $user->vLabel->name }}
                            @endif
                        </div>
                        @if($user->status == 'active')
                            <div class="text-center font-weight-light">
                                @if($user->approved == 0)
                                    Disapproved
                                @elseif($user->approved == 1)
                                    Approved
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($user->created_at)->format('F d, Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($user->updated_at)->format('F d, Y') }}
                    </td>
                    <td id="actions-{{ $user->id }}" class="action-holder">

                        @if($user->status == 'active')

                            {{-- <a id="edit-{{ $user->id }}" href="{{ route('admin.edit-details', ['id' => $user->id]) }}" title="Edit details">
                                <i class="fa fa-edit"></i>
                            </a> --}}
                            <a id="view-{{ $user->id }}" href="{{ route('admin.view-details', ['id' => $user->id]) }}" title="View details">
                                <i class="fa fa-file"></i>&ensp;View
                            </a>

                            <br>

                            @if($user->approved == 1)
                            <a class="act-approval" title="Disapprove" data-action-id="{{ $user->id }}" data-action-val=0>
                                <i class="fa fa-circle-xmark"></i>&ensp;Disapprove
                            </a>
                            <br>
                            @else
                            <a class="act-approval" title="Approve" data-action-id="{{ $user->id }}" data-action-val=1>
                                <i class="fa fa-circle-check"></i>&ensp;Approve
                            </a>
                            <br>
                            @endif
                            

                            @if($user->verified == -1)
                            <a class="act-status" title="elevate to Unverified" data-action-id="{{ $user->id }}" data-action-val=0>
                                <i class="fa fa-check"></i>&ensp;Unverified
                            </a>
                            <br>
                            @endif

                            

                            @if($user->verified == 0)
                            <a class="act-status" title="elevate to Verified" data-action-id="{{ $user->id }}" data-action-val=1>
                                <i class="fa fa-check-double"></i>&ensp;Verified
                            </a>
                            <br>
                            @endif

                            {{--
                            <a title="Delete record" data-action-id="{{ $user->id }}">
                                <i class="fa fa-trash"></i>
                            </a>
                            --}}

                        @endif



                    </td>
                </tr>
                @endforeach
                
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