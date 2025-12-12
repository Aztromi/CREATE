@extends('dashboard.index')

@section('userDashboard')
 
<section>
    <h1>Account Information</h1>
    <hr>
    <div class="row mt-60 mb-60">
        <ul class="horizontal-list">
            <li>
                <a href="{{ route('dashboard.edit-account') }}" class="btn bg_yellow">
                    <i class="fa fa-edit"></i> Edit Details
                </a>
            </li>
        </ul>
    </div>
    <hr>
    <div class="row mt-60 mb-60">
        <div class="col">
            <dl>
                <dt>MEMBERSHIP TYPE</dt>
                    <dd>
                        @switch($profile->user->verified)
                            @case(-1)
                                Member
                                @break
                            @case(0)
                                Unverified
                                @break
                            @case(1)
                                Verified
                                @break
                            @default
                                Unknown

                        @endswitch
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>STATUS</dt>
                    <dd>Pending Approval</dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>Directory Page</dt>
                    <dd>
                        Active
                        {{-- INACTIVE --}}
                    </dd>
            </dl>
        </div>
    </div>
    <hr>
    <div class="row mt-60">
        <div class="col">
            <h2>Display Name</h2>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt></dt>
                    <dd>
                        {{ $profile->dispName }}
                    </dd>
            </dl>
        </div>
    </div>
    <hr>
    <div class="row mt-60">
        <div class="col">
            <h2>Basic Information</h2>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>BANNER IMAGE</dt>
                    <dd>
                        <img src="" alt="" class="img-fluid">
                    </dd>
            </dl>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>PROFILE PHOTO</dt>
                    <dd>
                        <img src="" alt="" class="img-fluid">
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>FULL NAME</dt>
                    <dd>{{ $profile->user->name }}</dd>
            </dl>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>EMAIL ADDRESS</dt>
                    <dd>
                    {{ $profile->user->email }}
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>ALTERNATE EMAIL ADDRESS</dt>
                    <dd>email2@sample.com</dd>
            </dl>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>MOBILE NUMBER</dt>
                    <dd>
                        +63 XXX XXX XXXX
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>ALTERNATE MOBILE NUMBER</dt>
                    <dd>
                        +63 XXX XXX XXXX
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>MESSAGING APPS</dt>
                    <dd>Viber, others: ____</dd>
            </dl>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>TELEPHONE NUMBER</dt>
                    <dd>
                        +63 XX XXXX XXXX
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>ADDRESS</dt>
                    <dd>
                        Address Line, Area, City/Town, Province, Region, Country ZIPCODE
                    </dd>
            </dl>
        </div>
    </div>
    <hr>
    <div class="row mt-60">
        <div class="col">
            <h2>Representation Details</h2>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>NAME OF COMPANY / ACADEME / ASSOCIATION / GROUP / AGENCY</dt>
                    <dd>
                        Company Name
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>JOB TITLE / DESIGNATION</dt>
                    <dd>Graphic Designer</dd>
            </dl>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>REPRESENTATION / CATEGORY</dt>
                    <dd>
                        {{ $profile->uindie->expertise }}
                    </dd>
            </dl>
        </div>
    </div>
    <hr>
    <div class="row mt-60">
        <div class="col">
            <h2>Sectors of Interest</h2>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt></dt>
                    <dd>
                        Advertising
                    </dd>
            </dl>
        </div>
    </div>
    <hr>
    <div class="row mt-60">
        <div class="col">
            <h2>Document Requirements</h2>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>SAMPLE WORKS</dt>
                    <dd>
                        {{-- SAMPLE WORK 1 --}}
                        <img src="" alt="" class="img-fluid">
                    </dd>
                    <dd>
                        {{-- SAMPLE WORK 2 --}}
                        <img src="" alt="" class="img-fluid">
                    </dd>
                    <dd>
                        {{-- SAMPLE WORK 3 --}}
                        <img src="" alt="" class="img-fluid">
                    </dd>
            </dl>
        </div>
    </div>
    <div class="row mb-30">
        <div class="col">
            <dl>
                <dt>VALID BUSINESS PERMIT</dt>
                    <dd>
                        <a href="">
                            Link to document
                        </a>
                    </dd>
            </dl>
        </div>
        <div class="col">
            <dl>
                <dt>BIR CERTIFICATE REGISTRATION</dt>
                    <dd>
                        <a href="">
                            Link to document
                        </a>
                    </dd>
            </dl>
        </div>
    </div>
</section>

@endsection