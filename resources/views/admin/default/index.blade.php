@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Dashboard</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="row mb-60">
            <div class="mt-40 mb-20">
                <h2>Registered Users</h2>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        {{ $verifiedCount }}
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Verified Creatives
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                    {{ $unverifiedCount }}
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Unverified Creatives
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        {{ $registeredCount }}
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Registered Members
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        {{ $applicationCount }}
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Application Requests
                    </p>
                </div>
            </div>
        </div>
        <div class="row mb-60">
            <div class="mt-40 mb-20">
                <h2>Articles</h2>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        {{ $articlesCount }}
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Published Articles
                    </p>
                </div>
            </div>
        </div>
        <div class="row mb-60">
            <div class="mt-40 mb-20">
                <h2>Partners</h2>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        0
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Partners
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        0
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Business Solutions Partners
                    </p>
                </div>
            </div>
        </div>
        <div class="row mb-60">
            <div class="mt-40 mb-20">
                <h2>Events</h2>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        0
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Events
                    </p>
                </div>
            </div>
            <div class="col dashboard-rundown">
                <div>
                    <p>
                        {{ $eventsCount }}
                    </p>
                </div>
                <div>
                    <p>
                        Total Number of Creative Futures
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection