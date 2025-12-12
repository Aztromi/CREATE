@extends('admin.index')

@section('styles')
    @include('components.styles-DataTable')
@endsection

@section('scripts-bottom')
    @include('components.scripts-DataTable')
@endsection

@section('contentAdmin')

    @section('userDash_appRequest')
    <script src="{{ asset('js/admin/creatives_list.js?ver='.time()) }}"></script>

    @endsection
 
<section>

    <h1>Creatives</h1>
    <hr>

    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover application-list" id="cLists-data-table">
            <thead>
                <tr>
                    <!-- <th width="40%">Profile</td>
                    <th width="15%">Status</td>
                    <th width="15%">Total Creative Works</td>
                    <th width="15%">Creative Works Bookmarked</td>
                    <th width="15%">Profile followers</th>
                    <th width="15%">Profile Views</th>
                    <th width="15%">Total Messages</th> -->

                    <th>Profile</td>
                    <th>Status</td>
                    <th>Total Creative Works</td>
                    <th>Creative Works Bookmarked</td>
                    <th>Profile followers</th>
                    <th>Profile Views</th>
                    <th>Total Messages</th>


                </tr>
            </thead>
            <tbody>
                @foreach($userProfiles as $user)
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
                        <div class="
                            @if($user->verified == 1)
                                status_verified
                            @elseif($user->verified == 0)
                                status_unverified
                            @elseif($user->verified == -1)
                                status_member
                            @else
                                status_pending
                            @endif
                        ">
                            {{ $user->vLabel->name }}
                        </div>
                    </td>
                    <td>
                        @if($user->stories)
                            {{ $user->stories()->count() }}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if(!$user->stories->isEmpty())
                            {{ $user->allStoryBookmarksCount() }}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if($user->profile)
                            {{ $user->profile->bookmarks->count() }}
                        @else
                            0
                        @endif

                    </td>
                    <td>
                        @if($user->profile)
                            {{ $user->profile->views()->count() }}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        {{-- Messages --}}
                        0
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

    <!-- <h1>Creatives</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="form-group has-search">
            <span class="fa fa-search form-control-feedback"></span>
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </div>

    <div class="table-responsive mt-60 mb-60">
        <table class="table table-bordered table-hover creatives-list">
            <thead>
                <tr>
                    <th width="48%">Details</td>
                    <th width="13%">Status</td>
                    <th width="13%">Active Directory</td>
                    <th width="13%">Registration Date</td>
                    <th width="13%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        DISPLAY NAME
                        <br>sample@email.com
                    </td>
                    <td>
                        <div class="status_verified">
                            VERIFIED
                        </div>
                    </td>
                    <td>
                        <i class="fa fa-check"></i>
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
                <tr>
                    <td>
                        DISPLAY NAME
                        <br>sample@email.com
                    </td>
                    <td>
                        <div class="status_unverified">
                            UNVERIFIED
                        </div>
                    </td>
                    <td>
                        <i class="fa fa-times"></i>
                    </td>
                    <td>
                        Month XX, XXXX
                    </td>
                    <td class="action-holder">
                        <a href="" title="Edit details">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="" title="View details">
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
                    <td colspan="5"></td>
                </tr>
            </tfoot>
        </table>
    </div> -->

    
</section>

@endsection